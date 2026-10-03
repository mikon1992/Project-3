@extends('layouts.app')
@section('title', $activity->title)
@section('content')
<div class="card">
    <div class="row" style="justify-content:space-between">
        <div>
            <h1>{{ $activity->title }}</h1>
            <p><strong>{{ $activity->code }}</strong> · {{ $activity->category->name }}</p>
            <p><span class="badge">{{ ucfirst($activity->status) }}</span></p>
        </div>
        <div class="row">
            <a class="btn btn-light" href="{{ route('activities.edit', $activity) }}">Edit</a>
            @if($activity->status === 'draft')
                <form method="POST" action="{{ route('activities.publish', $activity) }}">@csrf<button class="btn btn-success">Publish</button></form>
            @endif
            @if($activity->status === 'published')
                <form method="POST" action="{{ route('activities.complete', $activity) }}">@csrf<button class="btn btn-success">Complete</button></form>
            @endif
            <form method="POST" action="{{ route('activities.destroy', $activity) }}" onsubmit="return confirm('Pindahkan activity ke trash?')">
                @csrf @method('DELETE')<button class="btn btn-danger">Soft Delete</button>
            </form>
        </div>
    </div>

    <div class="grid">
        <div>
            <p><strong>Lokasi</strong><br>{{ $activity->location }}</p>
            <p><strong>Mulai</strong><br>{{ $activity->start_at?->format('d-m-Y H:i') }}</p>
            <p><strong>Selesai</strong><br>{{ $activity->end_at?->format('d-m-Y H:i') }}</p>
            <p><strong>Kapasitas</strong><br>{{ $activity->registered_count }}/{{ $activity->capacity }}</p>
        </div>
        <div>
            @if($activity->poster_path)
                <img class="poster" src="{{ Storage::disk('public')->url($activity->poster_path) }}" alt="Poster {{ $activity->title }}">
            @else
                <p class="muted">Belum ada poster.</p>
            @endif
        </div>
    </div>

    <h2>Deskripsi</h2>
    <p>{{ $activity->description ?: '-' }}</p>
</div>

@if($activity->status === 'published')
<div class="card">
    <h2>Daftar sebagai peserta</h2>
    <form method="POST" action="{{ route('registrations.store', $activity) }}">
        @csrf
        <div class="grid">
            <div><label>Nama peserta</label><input name="participant_name" value="{{ old('participant_name') }}" required></div>
            <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        </div>
        <button style="margin-top:10px" type="submit">Daftar</button>
    </form>
</div>
@endif

<div class="card table-wrap">
    <h2>Registration ({{ $activity->registered_count }})</h2>
    <table>
        <thead><tr><th>Nama</th><th>Email</th><th>Waktu Daftar</th></tr></thead>
        <tbody>
        @forelse($activity->registrations as $registration)
            <tr><td>{{ $registration->participant_name }}</td><td>{{ $registration->email }}</td><td>{{ $registration->registered_at->format('d-m-Y H:i') }}</td></tr>
        @empty
            <tr><td colspan="3">Belum ada pendaftar.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
