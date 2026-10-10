<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class TokoController extends Controller
{
    public function index()
    {
        return view('index', ['barang' => Barang::all()]);
    }

    public function keranjang()
    {
        $cart = session('cart', []);
        $barang = Barang::whereIn('id', array_keys($cart))->get();

        $items = $barang->map(fn ($b) => [
            'barang'   => $b,
            'jumlah'   => $cart[$b->id],
            'subtotal' => $b->harga * $cart[$b->id],
        ]);

        return view('keranjang', [
            'items' => $items,
            'total' => $items->sum('subtotal'),
        ]);
    }

    public function tambah(Barang $barang)
    {
        if ($barang->stok < 1) {
            return back()->with('pesan', 'Stok ' . $barang->nama . ' habis.');
        }

        $cart = session('cart', []);
        $cart[$barang->id] = min(($cart[$barang->id] ?? 0) + 1, $barang->stok);
        session(['cart' => $cart]);

        return back();
    }

    public function kurang(Barang $barang)
    {
        $cart = session('cart', []);

        if (isset($cart[$barang->id])) {
            $cart[$barang->id]--;
            if ($cart[$barang->id] <= 0) {
                unset($cart[$barang->id]);
            }
        }

        session(['cart' => $cart]);
        return back();
    }

    public function hapus(Barang $barang)
    {
        $cart = session('cart', []);
        unset($cart[$barang->id]);
        session(['cart' => $cart]);

        return back();
    }

    public function kosongkan()
    {
        session()->forget('cart');
        return redirect()->route('keranjang');
    }
}