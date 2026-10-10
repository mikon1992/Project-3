<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body{font-family:sans-serif;max-width:360px;margin:60px auto;padding:0 16px}
        label{display:block;margin-top:12px}
        input{width:100%;padding:8px;box-sizing:border-box}
        button{margin-top:16px;padding:8px 16px}
        .error{background:#fde8e8;color:#b91c1c;padding:8px;border-radius:4px;margin-top:12px}
    </style>
</head>
<body>
    <h1>Login</h1>
    <p>Masuk untuk membuka dashboard</p>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password">

        <button type="submit">Masuk</button>
    </form>
</body>
</html>