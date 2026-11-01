{{-- -> resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Activity Manager')</title>
</head>
<body>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a> |
        <a href="{{ route('activities.index') }}">Activities</a> |
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
    <hr>

    @if (session('status'))
        <p style="color: green">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @yield('content')
</body>
</html>
