@extends('layouts.app')

@section('title', 'Buat laporan | Rimba Siaga')

@section('content')
<div class="heading"><div><span class="eyebrow">LAPORAN MASYARAKAT</span><h1>Buat laporan kejadian</h1><p class="sub">Sampaikan lokasi, waktu, kondisi, dan bukti jika tersedia.</p></div></div>
@include('reports._form')
@endsection