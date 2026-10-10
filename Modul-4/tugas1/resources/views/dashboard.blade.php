<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body{font-family:sans-serif;max-width:640px;margin:40px auto;padding:0 16px}
        header{display:flex;justify-content:space-between;align-items:center}
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </header>
    <hr>
    <p>Selamat datang, {{ auth()->user()->nama_lengkap }}!</p>
    <p>Halaman ini hanya bisa dibuka setelah login.</p>
    <p>Username: {{ auth()->user()->username }}</p>
</body>
</html>