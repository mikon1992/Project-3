@extends('layouts.app')
@section('title', 'Checkout - Toko Gundam')

@section('content')
<h1>Checkout</h1>

<div class="card" style="max-width:520px; padding:24px;">
    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="field">
            <label>Alamat Pengiriman</label>
            <textarea name="alamat_pengiriman" rows="3" required>{{ old('alamat_pengiriman', $alamat_default) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%">Buat Pesanan</button>
    </form>
    <p class="muted" style="margin-top:12px"><a href="{{ route('cart.index') }}">&larr; Kembali ke keranjang</a></p>
</div>
@endsection
