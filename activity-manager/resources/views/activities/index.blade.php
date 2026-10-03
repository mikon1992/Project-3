@extends('layouts.app')
@section('title', 'Activities')

@section('content')
<div class="card">
    <div class="row" style="justify-content:space-between">
        <h1>Daftar Activity</h1>
        <a class="btn" href="{{ route('activities.create') }}">+ Activity</a>
    </div>

    <form method="GET" action="{{ route('activities.index') }}" class="card">
        <div class="grid">
            <div>
                <label for="search">Search code/title</label>
                <input id="search" name="search" value="{{ request('search') }}" placeholder="Contoh: SEMINAR atau ACT-001">
            </div>
            <div>
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">Semua status</option>
                    @foreach(['draft','published','completed'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sort">Urutan start_at</label>
                <select id="sort" name="sort">
                    <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <button type="submit">Terapkan</button>
            <a class="btn btn-light" href="{{ route('activities.index') }}">Reset</a>
        </div>
    </form>
</div>

<div class="card table-wrap">
<table>
    <thead><tr><th>Kode</th><th>Judul</th><th>Kategori</th><th>Mulai</th><th>Kapasitas</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    @forelse($activities as $activity)
        <tr>
            <td>{{ $activity->code }}</td>
            <td>{{ $activity->title }}</td>
            <td>{{ $activity->category->name }}</td>
            <td>{{ $activity->start_at?->format('d-m-Y H:i') }}</td>
            <td>{{ $activity->registered_count }}/{{ $activity->capacity }}</td>
            <td><span class="badge">{{ ucfirst($activity->status) }}</span></td>
            <td>
                <a class="btn btn-light" href="{{ route('activities.show', $activity) }}">Detail</a>
            </td>
        </tr>
    @empty
        <tr><td colspan="7">Belum ada activity.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

<div class="pagination">
    {{ $activities->links() }}
</div>
@endsection
