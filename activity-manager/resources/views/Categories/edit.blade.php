@extends('layouts.app')
@section('title', 'Edit Category')
@section('content')
<div class="card">
<h1>Edit Category</h1>
<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf @method('PUT')
    <label>Nama</label><input name="name" value="{{ old('name', $category->name) }}" required>
    <label>Slug</label><input name="slug" value="{{ old('slug', $category->slug) }}">
    <div class="row" style="margin-top:12px"><button type="submit">Update</button><a class="btn btn-light" href="{{ route('categories.index') }}">Batal</a></div>
</form>
</div>
@endsection