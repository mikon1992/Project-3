@extends('layouts.app')
@section('title', 'Tambah Category')
@section('content')
<div class="card">
<h1>Tambah Category</h1>
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <label>Nama</label><input name="name" value="{{ old('name') }}" required>
    <label>Slug (opsional)</label><input name="slug" value="{{ old('slug') }}">
    <div class="row" style="margin-top:12px"><button type="submit">Simpan</button><a class="btn btn-light" href="{{ route('categories.index') }}">Batal</a></div>
</form>
</div>
@endsection