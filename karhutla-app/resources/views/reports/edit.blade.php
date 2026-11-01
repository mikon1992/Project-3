@extends('layouts.app')

@section('title', 'Ubah laporan | Rimba Siaga')

@section('content')
<div class="heading"><div><span class="eyebrow">LAPORAN RS-{{ $report->id }}</span><h1>Ubah laporan</h1><p class="sub">Perubahan hanya diizinkan saat status masih laporan baru.</p></div></div>
@include('reports._form')
@endsection
