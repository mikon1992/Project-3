@extends('layouts.app')
@section('title', $product->nama_barang . ' - Toko Gundam')

@section('content')
<div class="card" style="display:flex; flex-wrap:wrap;">
    <div class="product-thumb" style="flex:1; min-width:260px; height:280px;">
        @if ($product->gambar)
            <img src="{{ asset('images/products/' . $product->gambar) }}" alt="{{ $product->nama_barang }}">
        @else
            <span>Belum ada foto</span>
        @endif
    </div>
    <div style="flex:1; min-width:260px; padding:24px;">
        <h1 style="margin-bottom:8px">{{ $product->nama_barang }}</h1>
        <div class="price" style="font-size:1.3rem; margin-bottom:10px">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>

        @if ($product->isAvailable())
            <p class="stock-ok" style="margin-bottom:14px">Stok tersedia: {{ $product->stok }}</p>
        @else
            <p class="stock-out" style="margin-bottom:14px">Stok habis</p>
        @endif

        <p class="muted" style="margin-bottom:18px; line-height:1.6">{{ $product->deskripsi ?: 'Belum ada deskripsi.' }}</p>

        @auth
            @if ($product->isAvailable())
                <form method="POST" action="{{ route('cart.add', $product) }}" class="qty-form">
                    @csrf
                    <input type="number" name="qty" value="1" min="1" max="{{ $product->stok }}">
                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                </form>
            @else
                <button class="btn btn-disabled" disabled>Stok Habis</button>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-outline">Login untuk membeli</a>
        @endauth
    </div>
</div>

<p style="margin-top:18px"><a href="{{ route('products.index') }}" class="muted">&larr; Kembali ke katalog</a></p>
@endsection
