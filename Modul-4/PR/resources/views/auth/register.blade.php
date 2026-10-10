@extends('layouts.app')
@section('title', 'Daftar - Toko Gundam')

@section('content')
<div class="auth-box">
    <h1>Buat Akun</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="field">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required>
        </div>
        <div class="field">
            <label>No. HP</label>
            <input type="tel" name="no_hp" value="{{ old('no_hp') }}">
        </div>
        <div class="field">
            <label>Alamat</label>
            <textarea name="alamat" rows="2">{{ old('alamat') }}</textarea>
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="field">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%">Daftar</button>
    </form>
    <p class="muted" style="margin-top:14px">Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--red); font-weight:600">Login di sini</a></p>
</div>
@endsection
