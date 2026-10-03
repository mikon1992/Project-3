@extends('layouts.app')
@section('title', 'Edit Activity')
@section('content')
<div class="card">
    <h1>Edit Activity</h1>
    <p class="muted">Status tidak dapat diubah langsung di form ini. Gunakan aksi publish/complete.</p>
    @if($activity->poster_path)
        <p><img class="poster" src="{{ Storage::disk('public')->url($activity->poster_path) }}" alt="Poster {{ $activity->title }}"></p>
    @endif
    <form action="{{ route('activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('activities._form', ['submitLabel' => 'Update Activity'])
    </form>
</div>
@endsection