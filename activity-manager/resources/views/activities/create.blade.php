@extends('layouts.app')
@section('title', 'Tambah Activity')
@section('content')
<div class="card">
    <h1>Tambah Activity</h1>
    <p class="muted">Activity dibuat sebagai draft. Status tidak disimpan dari form edit umum.</p>
    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
        @include('activities._form', ['submitLabel' => 'Simpan Activity'])
    </form>
</div>
@endsection
