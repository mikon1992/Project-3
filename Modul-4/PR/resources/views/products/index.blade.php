@extends('layouts.app')
@section('title', 'Katalog - Toko Gundam')

@section('content')
<h1>Katalog Gunpla</h1>

<div class="product-grid">
    @foreach ($products as $product)
        <div class="card product-card">
            <a href="{{ route('products.show', $product) }}" class="product-thumb">
                @if ($product->gambar)
                    <img src="{{ asset('images/products/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" loading="lazy">
                @else
                    <span>Belum ada foto</span>
                @endif
            </a>
            <div class="product-body">
                <a href="{{ route('products.show', $product) }}" class="name">{{ $product->nama_barang }}</a>
                <div class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                @if ($product->isAvailable())
                    <div class="stock-ok">Stok: {{ $product->stok }}</div>
                @else
                    <div class="stock-out">Stok habis</div>
                @endif

                @auth
                    @if ($product->isAvailable())
                        <form method="POST" action="{{ route('cart.add', $product) }}" style="margin-top:4px">
                            @csrf
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn btn-primary btn-sm" style="width:100%">+ Keranjang</button>
                        </form>
                    @else
                        <button class="btn btn-disabled btn-sm" style="width:100%" disabled>Habis</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="width:100%;text-align:center;margin-top:4px">Login untuk beli</a>
                @endauth
            </div>
        </div>
    @endforeach
</div>

@include('partials.pagination', ['paginator' => $products])
@endsection
