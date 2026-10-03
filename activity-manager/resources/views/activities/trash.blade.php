@extends('layouts.app')
@section('title', 'Trash')
@section('content')
<div class="card">
    <h1>Trash Activity</h1>
    <p class="muted">Data pada halaman ini sudah di-soft-delete dan masih ada di database.</p>
</div>
<div class="card table-wrap">
<table>
    <thead><tr><th>Kode</th><th>Judul</th><th>Kategori</th><th>Dihapus</th><th>Aksi</th></tr></thead>
    <tbody>
    @forelse($activities as $activity)
        <tr>
            <td>{{ $activity->code }}</td>
            <td>{{ $activity->title }}</td>
            <td>{{ $activity->category->name }}</td>
            <td>{{ $activity->deleted_at?->format('d-m-Y H:i') }}</td>
            <td>
                <form method="POST" action="{{ route('activities.restore', $activity->id) }}">
                    @csrf
                    <button class="btn btn-success">Restore</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5">Trash kosong.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="pagination">{{ $activities->links() }}</div>
@endsection
