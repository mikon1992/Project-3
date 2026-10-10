@extends('layouts.app')
@section('title', 'Keranjang - Toko Gundam')

@section('content')
<h1>Keranjang Belanja</h1>

@if (empty($items))
    <div class="card empty-state">
        <p>Keranjangmu masih kosong.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top:10px">Lihat Katalog</a>
    </div>
@else
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th class="text-right">Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['product']->nama_barang }}</td>
                        <td>Rp {{ number_format($item['product']->harga, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="qty-form">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="{{ $item['product']->stok }}">
                                <button type="submit" class="btn btn-outline btn-sm">Ubah</button>
                            </form>
                        </td>
                        <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:#fdecea;color:var(--red-dark)">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="totals">
        Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
    </div>

    <div style="text-align:right; margin-top:14px">
        <a href="{{ route('checkout.create') }}" class="btn btn-primary">Checkout</a>
    </div>
@endif
@endsection
