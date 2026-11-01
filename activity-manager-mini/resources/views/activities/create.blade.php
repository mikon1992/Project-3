{{-- -> resources/views/activities/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Tambah Aktivitas')

@section('content')
    <h1>Tambah Aktivitas</h1>
    <form method="POST" action="{{ route('activities.store') }}">
        @csrf
        @include('activities._form')
        <button type="submit">Simpan</button>
        <a href="{{ route('activities.index') }}">Batal</a>
    </form>
@endsection
