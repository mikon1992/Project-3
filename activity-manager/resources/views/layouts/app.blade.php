<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Manajemen Kegiatan')</title>
    <style>
        body{font-family:Arial,sans-serif;max-width:1100px;margin:0 auto;padding:24px;color:#222;background:#f7f8fa}
        nav{display:flex;gap:14px;align-items:center;margin-bottom:20px}
        nav a{color:#1f4f76;text-decoration:none;font-weight:600}
        .card{background:#fff;border:1px solid #ddd;border-radius:10px;padding:18px;margin-bottom:18px}
        .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:16px}
        .row{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
        label{font-weight:700;display:block;margin:8px 0 5px}
        input,select,textarea{width:100%;box-sizing:border-box;padding:9px;border:1px solid #bbb;border-radius:6px}
        button,.btn{border:0;border-radius:6px;padding:9px 13px;cursor:pointer;background:#234e70;color:#fff;text-decoration:none;display:inline-block}
        .btn-light{background:#e9eef3;color:#222}.btn-danger{background:#a92d2d}.btn-success{background:#2f6f3e}
        table{width:100%;border-collapse:collapse}.table-wrap{overflow:auto}th,td{border:1px solid #ddd;padding:9px;text-align:left}th{background:#eef2f6}
        .muted{color:#666}.error{color:#a00000;font-size:.9rem}.success{padding:10px;background:#e6f4ea;border:1px solid #b7dfc0}.flash-error{padding:10px;background:#fdecec;border:1px solid #efb8b8}
        .badge{display:inline-block;padding:4px 8px;border-radius:99px;background:#e8edf2;font-size:.82rem}.poster{max-width:360px;max-height:480px;object-fit:cover;border-radius:8px;border:1px solid #ddd}
        .pagination{display:flex;gap:8px;margin-top:14px;flex-wrap:wrap}.pagination a,.pagination span{padding:7px 10px;border:1px solid #ccc;border-radius:5px;text-decoration:none}
    </style>
</head>
<body>
<nav>
    <a href="{{ route('activities.index') }}">Activities</a>
    <a href="{{ route('categories.index') }}">Categories</a>
    <a href="{{ route('activities.trash') }}">Trash</a>
</nav>

@if(session('success'))
    <div class="success card">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash-error card">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="flash-error card">
        <strong>Periksa input:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@yield('content')
</body>
</html>
