{{-- -> resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Halo, {{ auth()->user()->nama_lengkap ?? auth()->user()->username }}.</p>

    <p><a href="{{ route('activities.index') }}">Kelola Activities</a></p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
