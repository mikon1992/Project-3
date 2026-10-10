@extends('layouts.app')
@section('title', 'Login - Toko Gundam')

@section('content')
<div class="auth-box">
    <h1>Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%">Masuk</button>
    </form>
    <p class="muted" style="margin-top:14px">Belum punya akun? <a href="{{ route('register') }}" style="color:var(--red); font-weight:600">Daftar di sini</a></p>
</div>
@endsection
