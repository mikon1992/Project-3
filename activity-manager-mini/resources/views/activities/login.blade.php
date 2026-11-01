{{-- -> resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <p>
            <label>Username<br>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus>
            </label>
        </p>
        <p>
            <label>Password<br>
                <input type="password" name="password" required>
            </label>
        </p>
        <button type="submit">Masuk</button>
    </form>
</body>
</html>
