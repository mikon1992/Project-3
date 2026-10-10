@extends('layouts.app')
@section('title', 'Riwayat Pesanan - Toko Gundam')

@section('content')
<h1>Riwayat Pesanan</h1>

@if ($orders->isEmpty())
    <div class="card empty-state">
        <p>Belum ada pesanan.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top:10px">Mulai Belanja</a>
    </div>
@else
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Jumlah Barang</th>
                    <th class="text-right">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id_order }}</td>
                        <td>{{ $order->tanggal_order->format('d M Y H:i') }}</td>
                        <td>{{ $order->details->sum('jumlah_beli') }}</td>
                        <td class="text-right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td><a href="{{ route('orders.show', $order) }}" class="btn btn-outline btn-sm">Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('partials.pagination', ['paginator' => $orders])
@endif
@endsection
