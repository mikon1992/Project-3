<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $idBarang => $qty) {
            $product = Product::find($idBarang);

            if (! $product) {
                continue; // produk sudah dihapus dari katalog
            }

            $qty = min($qty, $product->stok); // jaga-jaga kalau stok berkurang setelah ditambah ke cart
            $subtotal = $product->harga * $qty;
            $total += $subtotal;

            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        if ($product->stok < 1) {
            return back()->withErrors(['qty' => "{$product->nama_barang} sedang habis."]);
        }

        $cart = $request->session()->get('cart', []);
        $current = $cart[$product->id_barang] ?? 0;
        $newQty = $current + $data['qty'];

        if ($newQty > $product->stok) {
            return back()->withErrors([
                'qty' => "Jumlah melebihi stok. Stok tersedia: {$product->stok}.",
            ]);
        }

        $cart[$product->id_barang] = $newQty;
        $request->session()->put('cart', $cart);

        return back()->with('success', "{$product->nama_barang} ditambahkan ke keranjang.");
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        if ($data['qty'] > $product->stok) {
            return back()->withErrors([
                'qty' => "Jumlah melebihi stok. Stok tersedia: {$product->stok}.",
            ]);
        }

        $cart = $request->session()->get('cart', []);
        $cart[$product->id_barang] = $data['qty'];
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id_barang]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }
}
