{{-- -> resources/views/activities/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Aktivitas')

@section('content')
    <h1>Edit Aktivitas</h1>
    <form method="POST" action="{{ route('activities.update', $activity) }}">
        @csrf
        @method('PUT')
        @include('activities._form')
        <button type="submit">Perbarui</button>
        <a href="{{ route('activities.index') }}">Batal</a>
    </form>
@endsection
