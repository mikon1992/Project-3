@extends('layout')

@section('isi')
    <h2>Daftar barang</h2>
    @foreach ($barang as $b)
        <div class="row">
            <span>{{ $b->nama }} Rp {{ number_format($b->harga, 0, ',', '.') }} (stok {{ $b->stok }})</span>
            <form method="POST" action="{{ route('keranjang.tambah', $b) }}">
                @csrf
                <button type="submit">Masukkan ke keranjang</button>
            </form>
        </div>
    @endforeach
@endsection