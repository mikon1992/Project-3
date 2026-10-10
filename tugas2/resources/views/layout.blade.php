<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Alat Tulis</title>
    <style>
        body{font-family:sans-serif;max-width:640px;margin:0 auto;padding:16px}
        nav{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #ccc;padding-bottom:8px}
        .row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #eee}
        .pesan{background:#fff3cd;padding:8px;margin:8px 0}
        form{display:inline}
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('index') }}"><strong>Toko Alat Tulis</strong></a>
        <a href="{{ route('keranjang') }}">Keranjang ({{ array_sum(session('cart', [])) }})</a>
    </nav>
    @if (session('pesan'))
        <div class="pesan">{{ session('pesan') }}</div>
    @endif
    @yield('isi')
</body>
</html>