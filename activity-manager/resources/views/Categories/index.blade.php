@extends('layouts.app')
@section('title', 'Categories')
@section('content')
<div class="card">
    <div class="row" style="justify-content:space-between">
        <h1>Categories</h1>
        <a class="btn" href="{{ route('categories.create') }}">+ Category</a>
    </div>
</div>
<div class="card table-wrap">
<table>
    <thead><tr><th>Nama</th><th>Slug</th><th>Dipakai Activity</th><th>Aksi</th></tr></thead>
    <tbody>
    @forelse($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->activities_count }}</td>
            <td class="row">
                <a class="btn btn-light" href="{{ route('categories.edit', $category) }}">Edit</a>
                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori?')">
                    @csrf @method('DELETE')<button class="btn btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4">Belum ada kategori.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="pagination">{{ $categories->links() }}</div>
@endsection