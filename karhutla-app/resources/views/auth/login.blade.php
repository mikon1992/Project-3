<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Rimba Siaga</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;background:#f4f7f3;color:#1d2b22;font-family:Arial,sans-serif}.card{width:min(100% - 32px,420px);padding:32px;background:#fff;border:1px solid #e3eae2;border-radius:12px;box-shadow:0 12px 35px #193b2310}.brand{font-size:13px;font-weight:700;letter-spacing:1px;color:#176b43}.brand span{color:#829987;font-weight:400}.card h1{font-size:26px;margin:28px 0 8px}.muted{font-size:13px;color:#718077;margin:0 0 24px}.field{display:grid;gap:7px;margin:16px 0;font-size:13px;font-weight:600}.field input{height:43px;padding:0 12px;border:1px solid #dce4dc;border-radius:6px;font:inherit;font-weight:400}.remember{display:flex;align-items:center;gap:7px;color:#657168;font-size:12px;margin:4px 0 18px}.button{width:100%;height:44px;border:0;border-radius:6px;background:#176b43;color:#fff;font-size:13px;font-weight:700}.button:hover{background:#105735}.error{margin:5px 0;color:#a9433c;font-size:12px}.demo{margin-top:24px;padding:14px;background:#f5f8f4;border-radius:7px;color:#68756b;font-size:12px;line-height:1.7}.demo strong{color:#33483a}.notice{margin-top:18px;color:#929d94;font-size:10px;line-height:1.5}
    </style>
</head>
<body>
    <main class="card">
        <div class="brand">RIMBA<span>SIAGA</span></div>
        <h1>Masuk ke aplikasi</h1>
        <p class="muted">Gunakan akun demo untuk membuka ruang pemantauan.</p>
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <label class="field">Email
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')<span class="error">{{ $message }}</span>@enderror
            </label>
            <label class="field">Kata sandi
                <input type="password" name="password" required autocomplete="current-password">
                @error('password')<span class="error">{{ $message }}</span>@enderror
            </label>
            <label class="remember"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
            <button class="button" type="submit">Masuk</button>
        </form>
        <section class="demo">
            <strong>Akun demo</strong><br>
            Pelapor Andi: andi@demo.id<br>
            Pelapor Maya: maya@demo.id<br>
            Relawan Sari: sari@demo.id<br>
            Koordinator Budi: budi@demo.id<br>
            Kata sandi semua akun: karhutla123
        </section>
        <p class="notice">Laporan dan peninjauan merupakan informasi komunitas, bukan penetapan resmi terjadinya kebakaran.</p>
    </main>
</body>
</html>