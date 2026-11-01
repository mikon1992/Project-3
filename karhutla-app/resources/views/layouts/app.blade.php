<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Rimba Siaga')</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f5f8f5;color:#1d2b22;font:14px Arial,sans-serif}.top{height:62px;background:#fff;border-bottom:1px solid #e2e9e2;display:flex;justify-content:space-between;align-items:center;padding:0 max(20px,calc((100% - 1180px)/2))}.brand{color:#176b43;text-decoration:none;font-weight:700;letter-spacing:1px}.brand span{color:#84958a;font-weight:400}.links{display:flex;align-items:center;gap:18px}.links a{color:#56645a;text-decoration:none;font-size:12px}.links form{display:inline}.links button{border:1px solid #dce4dc;background:#fff;padding:8px 11px;border-radius:6px;color:#536157}.wrap{max-width:1180px;padding:30px 22px;margin:0 auto}.heading{display:flex;justify-content:space-between;align-items:center;gap:14px;margin-bottom:20px}.heading h1{font-size:26px;margin:7px 0}.eyebrow{color:#32764f;font-weight:700;letter-spacing:1px;font-size:10px}.sub{margin:0;color:#758178;font-size:12px}.panel{background:#fff;border:1px solid #e3eae2;border-radius:8px;padding:18px;margin-bottom:16px}.button{display:inline-block;text-decoration:none;border:0;border-radius:6px;background:#176b43;color:#fff;font-weight:700;font-size:12px;padding:10px 14px;cursor:pointer}.button.secondary{background:#fff;border:1px solid #dce4dc;color:#526157}.button.danger{background:#fff0ee;color:#a64a42}.notice{padding:10px 12px;margin:12px 0;border-radius:6px;background:#edf6ee;color:#356a43;font-size:12px}.errors{padding:10px 13px;margin:12px 0;background:#fff0ee;color:#a6453d;border-radius:6px}.errors ul{margin:4px 0;padding-left:18px}.filters,.form-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;margin-bottom:14px}.field{display:grid;gap:6px;margin:12px 0;color:#445148;font-size:12px;font-weight:600}.field input,.field select,.field textarea,.filters input,.filters select{width:100%;padding:9px 10px;border:1px solid #dce4dc;border-radius:5px;background:#fff;color:#26352b;font:inherit;font-size:12px}.field textarea{min-height:90px;resize:vertical}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;white-space:nowrap}th{text-align:left;padding:10px;background:#f7f9f7;color:#7a877e;font-size:9px;letter-spacing:.5px}td{padding:12px 10px;border-top:1px solid #edf0ed;font-size:11px;color:#56645a}td a{color:#246b45;text-decoration:none;font-weight:700}.badge{display:inline-block;padding:5px 8px;border-radius:20px;background:#edf4ee;color:#4b7655;font-size:9px}.badge.berat{background:#fff0ee;color:#a54a42}.badge.sedang{background:#fbf3df;color:#a27822}.badge.ringan{background:#edf5ee;color:#4b7655}.meta{font-size:10px;color:#829087}.pagination{display:flex;justify-content:space-between;align-items:center;margin-top:14px;color:#768278;font-size:11px}.pagination nav{display:flex;gap:5px}.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}.detail-item{padding:11px;background:#f7f9f7;border-radius:5px}.detail-item small{display:block;color:#89958c;font-size:10px;margin-bottom:5px}.detail-item strong{font-size:12px}.actions{display:flex;flex-wrap:wrap;gap:8px;margin-top:16px}.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px}.stat{padding:16px;background:#fff;border:1px solid #e3eae2;border-radius:7px}.stat small{display:block;color:#849087;font-size:10px}.stat strong{display:block;margin-top:7px;font-size:22px}.footer-note{color:#929c94;font-size:10px;margin:18px 0}@media(max-width:760px){.top{height:auto;padding:14px 16px;align-items:flex-start;gap:12px}.links{gap:9px;flex-wrap:wrap;justify-content:flex-end}.wrap{padding:23px 14px}.heading h1{font-size:22px}.filters,.form-grid{grid-template-columns:1fr 1fr}.stat-grid{grid-template-columns:1fr 1fr}.detail-grid{grid-template-columns:1fr}.heading{align-items:flex-start}}
    </style>
</head>
<body>
    <header class="top">
        <a class="brand" href="{{ route('reports.index') }}">RIMBA<span>SIAGA</span></a>
        @auth
            <nav class="links">
                <a href="{{ route('reports.index') }}">Laporan</a>
                @if(auth()->user()->isPelapor())<a href="{{ route('reports.create') }}">Buat laporan</a>@endif
                @if(auth()->user()->isRelawan() || auth()->user()->isKoordinator())<a href="{{ route('reports.recap') }}">Rekap</a>@endif
                @if(auth()->user()->isKoordinator())<a href="{{ route('areas.index') }}">Area</a>@endif
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
            </nav>
        @endauth
    </header>
    <main class="wrap">
        @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="errors"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @yield('content')
    </main>
    <script src="{{ asset('js/area-summary.js') }}" defer></script>
</body>
</html>
