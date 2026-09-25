@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>
    <p><strong>Tanggal:</strong> {{ $activity->activity_date->format('d M Y') }}</p>
    <p><strong>Kategori:</strong> {{ $activity->category }}</p>
    <p><strong>Status:</strong> {{ $activity->status }}</p>
    <p><strong>Deskripsi:</strong></p>
    <p>{{ $activity->description }}</p>

    <a href="{{ route('activities.index') }}">Kembali ke Daftar</a>
@endsection