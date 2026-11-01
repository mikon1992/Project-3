{{-- -> resources/views/activities/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Daftar Aktivitas')

@section('content')
    <h1>Daftar Aktivitas</h1>
    <p><a href="{{ route('activities.create') }}">+ Tambah aktivitas</a></p>

    <table border="1" cellpadding="6">
        <thead>
            <tr><th>Judul</th><th>Tanggal</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($activities as $a)
                <tr>
                    <td>{{ $a->title }}</td>
                    <td>{{ $a->activity_date->format('Y-m-d') }}</td>
                    <td>{{ $a->category }}</td>
                    <td>{{ $a->status }}</td>
                    <td>
                        <a href="{{ route('activities.edit', $a) }}">Edit</a>
                        <form method="POST" action="{{ route('activities.destroy', $a) }}" style="display:inline"
                              onsubmit="return confirm('Hapus aktivitas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
