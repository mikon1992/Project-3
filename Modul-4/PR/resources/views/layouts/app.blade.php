<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Toko Gundam')</title>
    <style>
        /* CSS polos, ditulis manual, tanpa Bootstrap/Tailwind/CDN apa pun. */
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #fafafa;
            color: #222;
        }
        a { color: #1a56db; text-decoration: none; }
        a:hover { text-decoration: underline; }

        header.topbar {
            background: #fff;
            border-bottom: 1px solid #ddd;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        header.topbar .brand {
            font-size: 1.25rem;
            font-weight: bold;
            color: #222;
        }
        header.topbar nav { display: flex; align-items: center; gap: 16px; font-size: 0.95rem; }
        header.topbar form { margin: 0; display: inline; }
        header.topbar button.link-btn {
            background: none; border: none; color: #1a56db; cursor: pointer;
            font: inherit; padding: 0; text-decoration: none;
        }
        header.topbar button.link-btn:hover { text-decoration: underline; }
        .cart-badge {
            background: #c0392b; color: #fff; border-radius: 10px;
            padding: 0 6px; font-size: 0.72rem; margin-left: 3px;
        }

        main.container { max-width: 1000px; margin: 0 auto; padding: 24px 20px 60px; }

        .alert { padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; font-size: 0.92rem; border: 1px solid; }
        .alert-success { background: #eafaf0; color: #1e7e34; border-color: #b7e4c7; }
        .alert-error { background: #fdecea; color: #a82822; border-color: #f5b3ae; }
        .error-list { background: #fdecea; color: #a82822; border: 1px solid #f5b3ae; border-radius: 4px; padding: 10px 14px 10px 28px; margin-bottom: 16px; font-size: 0.92rem; }

        h1 { font-size: 1.4rem; color: #222; margin-bottom: 16px; }
        h2 { font-size: 1.1rem; color: #222; }

        .btn {
            display: inline-block; padding: 8px 16px; border-radius: 4px; border: 1px solid transparent;
            font-weight: bold; cursor: pointer; font-size: 0.88rem;
        }
        .btn-primary { background: #c0392b; color: #fff; }
        .btn-primary:hover { background: #a3291d; text-decoration: none; }
        .btn-outline { background: #fff; color: #333; border-color: #bbb; }
        .btn-outline:hover { background: #f0f0f0; text-decoration: none; }
        .btn-sm { padding: 5px 10px; font-size: 0.82rem; }
        .btn-disabled { background: #e0e0e0; color: #888; cursor: not-allowed; }

        input[type=text], input[type=email], input[type=password], input[type=number], input[type=tel], textarea, select {
            width: 100%; padding: 7px 10px; border: 1px solid #ccc; border-radius: 4px;
            font-size: 0.92rem; font-family: inherit;
        }
        label { display: block; font-weight: bold; font-size: 0.85rem; margin-bottom: 4px; color: #444; }
        .field { margin-bottom: 14px; }

        .card { background: #fff; border: 1px solid #ddd; border-radius: 4px; }

        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
        .product-card { display: flex; flex-direction: column; }
        .product-thumb {
            height: 150px; background: #f0f0f0; border-bottom: 1px solid #ddd;
            display: flex; align-items: center; justify-content: center;
            color: #999; font-size: 0.82rem; text-align: center; overflow: hidden;
        }
        .product-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .product-body { padding: 12px 14px; display: flex; flex-direction: column; gap: 4px; flex: 1; }
        .product-body .name { font-weight: bold; color: #222; font-size: 0.95rem; }
        .product-body .price { color: #c0392b; font-weight: bold; }
        .stock-ok { color: #1e7e34; font-size: 0.8rem; }
        .stock-out { color: #c0392b; font-size: 0.8rem; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; background: #fff; }
        table th, table td { padding: 10px 12px; border-bottom: 1px solid #e5e5e5; text-align: left; font-size: 0.9rem; }
        table th { background: #f5f5f5; }
        .qty-form { display: flex; gap: 6px; align-items: center; }
        .qty-form input { width: 60px; padding: 5px 7px; }
        .text-right { text-align: right; }
        .totals { margin-top: 12px; text-align: right; font-size: 1rem; }
        .totals strong { color: #c0392b; font-size: 1.2rem; }

        .auth-box { max-width: 400px; margin: 10px auto; background: #fff; border: 1px solid #ddd; border-radius: 4px; padding: 24px; }
        .muted { color: #777; font-size: 0.85rem; }
        .empty-state { text-align: center; padding: 50px 20px; color: #777; }

        .simple-pagination { margin-top: 18px; display: flex; gap: 6px; flex-wrap: wrap; }
        .simple-pagination .page-link {
            border: 1px solid #ccc; border-radius: 4px; padding: 5px 10px; font-size: 0.85rem; color: #333; background: #fff;
        }
        .simple-pagination a.page-link:hover { background: #f0f0f0; text-decoration: none; }
        .simple-pagination .page-link.active { background: #c0392b; color: #fff; border-color: #c0392b; }
        .simple-pagination .page-link.disabled { color: #bbb; }

        .status-pill { background: #eef2ff; color: #333; padding: 2px 8px; border-radius: 4px; font-size: 0.78rem; }
    </style>
</head>
<body>
    <header class="topbar">
        <a href="{{ route('products.index') }}" class="brand">Toko Gundam</a>
        <nav>
            <a href="{{ route('products.index') }}">Katalog</a>
            @auth
                <a href="{{ route('cart.index') }}">
                    Keranjang
                    @php($cartCount = collect(session('cart', []))->sum())
                    @if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
                </a>
                <a href="{{ route('orders.index') }}">Riwayat Pesanan</a>
                <span class="muted">Hai, {{ auth()->user()->nama_lengkap }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link-btn">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </nav>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @yield('content')
    </main>
</body>
</html>
