@extends('layout')

@section('isi')
    <h2>Keranjang belanja</h2>

    @forelse ($items as $item)
        <div class="row">
            <div>
                <strong>{{ $item['barang']->nama }}</strong><br>
                Rp {{ number_format($item['barang']->harga, 0, ',', '.') }} x {{ $item['jumlah'] }}
                = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
            </div>
            <div>
                <form method="POST" action="{{ route('keranjang.kurang', $item['barang']) }}">@csrf<button>-</button></form>
                {{ $item['jumlah'] }}
                <form method="POST" action="{{ route('keranjang.tambah', $item['barang']) }}">@csrf<button>+</button></form>
                <form method="POST" action="{{ route('keranjang.hapus', $item['barang']) }}">@csrf<button>Hapus</button></form>
            </div>
        </div>
    @empty
        <p>Keranjang masih kosong. <a href="{{ route('index') }}">Belanja dulu</a></p>
    @endforelse

    @if ($items->isNotEmpty())
        <h3>Total Rp {{ number_format($total, 0, ',', '.') }}</h3>
        <form method="POST" action="{{ route('keranjang.kosongkan') }}">
            @csrf
            <button>Kosongkan keranjang</button>
        </form>
    @endif
@endsection