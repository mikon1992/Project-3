<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        return view('cart.checkout', [
            'alamat_default' => $request->user()->alamat,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'alamat_pengiriman' => ['required', 'string', 'max:500'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        try {
            $order = DB::transaction(function () use ($cart, $data, $request) {
                $total = 0;
                $lines = [];

                // 1) kunci baris produk dan validasi stok SEBELUM menulis apa pun
                foreach ($cart as $idBarang => $qty) {
                    $product = Product::where('id_barang', $idBarang)->lockForUpdate()->first();

                    if (! $product) {
                        throw ValidationException::withMessages([
                            'cart' => 'Salah satu barang di keranjang sudah tidak tersedia.',
                        ]);
                    }

                    if ($qty > $product->stok) {
                        throw ValidationException::withMessages([
                            'cart' => "Stok {$product->nama_barang} tidak mencukupi (sisa {$product->stok}).",
                        ]);
                    }

                    $subtotal = $product->harga * $qty;
                    $total += $subtotal;
                    $lines[] = ['product' => $product, 'qty' => $qty, 'harga' => $product->harga];
                }

                // 2) buat order
                $order = Order::create([
                    'id_user' => $request->user()->id_user,
                    'tanggal_order' => now(),
                    'total_harga' => $total,
                    'alamat_pengiriman' => $data['alamat_pengiriman'],
                ]);

                // 3) simpan detail dan kurangi stok, semua dalam transaction yang sama
                foreach ($lines as $line) {
                    $order->details()->create([
                        'id_barang' => $line['product']->id_barang,
                        'harga_satuan' => $line['harga'],
                        'jumlah_beli' => $line['qty'],
                    ]);

                    $line['product']->decrement('stok', $line['qty']);
                }

                return $order;
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        // 4) hanya dikosongkan setelah transaction berhasil
        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Checkout berhasil! Terima kasih sudah belanja.');
    }
}
