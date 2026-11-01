<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ruang kerja | Rimba Siaga</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;background:#f4f7f3;color:#1d2b22;font-family:Arial,sans-serif}.bar{height:64px;background:#fff;border-bottom:1px solid #e4eae4;display:flex;align-items:center;justify-content:space-between;padding:0 max(24px,calc((100% - 1040px)/2))}.brand{font-size:13px;font-weight:700;letter-spacing:1px;color:#176b43}.brand span{color:#829987;font-weight:400}.logout{border:1px solid #dce4dc;background:#fff;border-radius:6px;padding:9px 13px;color:#526157;font-weight:600}.wrap{max-width:1040px;margin:48px auto;padding:0 24px}.wrap h1{font-size:29px;margin:8px 0}.eyebrow{color:#32764f;letter-spacing:1px;font-size:10px;font-weight:700}.intro{color:#718077;font-size:14px}.panel{margin-top:24px;background:#fff;border:1px solid #e3eae2;border-radius:9px;padding:22px}.panel p{color:#647168;font-size:14px;line-height:1.7}.role{display:inline-block;border-radius:20px;background:#edf5ed;padding:6px 10px;color:#32704c;font-size:11px;font-weight:700}.warning{border-left:3px solid #d3a54c;background:#fcf8ec;padding:12px 14px;font-size:12px;color:#796535;margin-top:18px}
    </style>
</head>
<body>
    <header class="bar">
        <div class="brand">RIMBA<span>SIAGA</span></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout" type="submit">Keluar</button>
        </form>
    </header>
    <main class="wrap">
        <span class="eyebrow">RUANG KERJA KOMUNITAS</span>
        <h1>Halo, {{ auth()->user()->name }}</h1>
        <p class="intro">Kamu masuk sebagai <span class="role">{{ ucfirst(auth()->user()->role) }}</span>.</p>
        <section class="panel">
            <h2>Rimba Siaga</h2>
            <p>Autentikasi dan akun demo sudah aktif. Fitur laporan akan ditambahkan bertahap pada tahap berikutnya.</p>
            <div class="warning">Status dalam aplikasi menggambarkan proses komunitas, bukan verifikasi resmi bahwa kebakaran terjadi atau telah padam.</div>
        </section>
    </main>
</body>
</html>
