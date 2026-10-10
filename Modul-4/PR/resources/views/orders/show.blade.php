@extends('layouts.app')
@section('title', 'Detail Pesanan - Toko Gundam')

@section('content')
<h1>Pesanan {{ $order->id_order }}</h1>
<p class="muted" style="margin-top:-10px; margin-bottom:18px">
    {{ $order->tanggal_order->format('d M Y H:i') }} &middot;
    <span class="status-pill">Alamat: {{ $order->alamat_pengiriman }}</span>
</p>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Barang</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $detail)
                <tr>
                    <td>{{ $detail->product->nama_barang ?? $detail->id_barang }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah_beli }}</td>
                    <td class="text-right">Rp {{ number_format($detail->subtotal(), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="totals">
    Total Bayar: <strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
</div>

<p style="margin-top:20px"><a href="{{ route('orders.index') }}" class="muted">&larr; Kembali ke riwayat pesanan</a></p>
@endsection
