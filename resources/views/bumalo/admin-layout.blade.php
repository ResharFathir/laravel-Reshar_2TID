<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin · Bumalo')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shop-theme.css') }}">
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f5f6f3;color:#18221f;font-family:'DM Sans',sans-serif}a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}
        .admin-shell{min-height:100vh}.admin-sidebar{position:fixed;inset:0 auto 0 0;width:250px;background:#142a22;color:#e8f0e9;padding:26px 17px;display:flex;flex-direction:column;z-index:5}.admin-brand{font:800 24px Manrope;letter-spacing:-1px;padding:0 13px 31px}.admin-brand span{color:#b8f36b}.admin-caption{padding:12px 13px 8px;color:#8da196;font-size:10px;font-weight:700;letter-spacing:.16em}.admin-menu{display:grid;gap:5px}.admin-menu a,.admin-menu .admin-link-button{display:flex;align-items:center;gap:12px;padding:12px 13px;border:0;border-radius:11px;color:#c1cec5;font:600 13px 'DM Sans',sans-serif;text-decoration:none;transition:.2s}.admin-menu .admin-link-button{width:100%;background:none;text-align:left;cursor:pointer}.admin-menu a:hover,.admin-menu a.active,.admin-menu .admin-link-button:hover{background:#284238;color:#c8f879}.admin-menu .nav-icon{width:19px;text-align:center;font-size:16px}.admin-sidebar-bottom{margin-top:auto;border-top:1px solid #ffffff1a;padding-top:16px}.admin-main{margin-left:250px;min-height:100vh}.admin-topbar{height:70px;background:#fff;border-bottom:1px solid #e8ebe5;display:flex;align-items:center;justify-content:space-between;padding:0 34px}.admin-topbar small{color:#77837c}.admin-user{font-size:13px;font-weight:700}.admin-content{max-width:1500px;margin:auto;padding:20px 34px 48px}.admin-content .wrap{width:100%}.admin-content .section{padding:10px 0}.admin-content .admin-title{margin:18px 0 24px}.admin-content .card,.admin-content .metric{box-shadow:0 7px 25px #10271c08}.admin-content .metrics{grid-template-columns:repeat(3,minmax(0,1fr))}.admin-content .admin-order{box-shadow:0 5px 18px #10271c08}.admin-flash{margin:16px auto 0;width:calc(100% - 68px);max-width:1432px}.admin-toggle{display:none;border:0;background:#edf4e9;border-radius:9px;padding:8px 11px;font-weight:700}
        @media(max-width:900px){.admin-sidebar{width:220px}.admin-main{margin-left:220px}.admin-content{padding:18px 22px 38px}.admin-topbar{padding:0 22px}.admin-flash{width:calc(100% - 44px)}}
        @media(max-width:700px){.admin-sidebar{position:static;width:auto;height:auto;padding:12px;display:block}.admin-brand{padding:4px 8px 12px}.admin-caption,.admin-sidebar-bottom{display:none}.admin-menu{display:flex;overflow-x:auto;gap:5px}.admin-menu a{white-space:nowrap;padding:10px}.admin-main{margin:0}.admin-topbar{height:58px;padding:0 16px}.admin-toggle{display:block}.admin-content{padding:14px}.admin-flash{width:calc(100% - 28px)}.admin-content .metrics{grid-template-columns:repeat(2,minmax(0,1fr))}.admin-content .columns{grid-template-columns:1fr!important}}
        @media(max-width:420px){.admin-content .metrics{grid-template-columns:1fr}.admin-content .admin-title{align-items:flex-start;flex-direction:column;gap:12px}}
    </style><link rel="stylesheet" href="{{ asset('css/admin-ai.css') }}">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}">bumalo<span>.</span></a>
        <div class="admin-caption">MENU TOKO</div>
        <nav class="admin-menu">
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="nav-icon">⌂</span>Ringkasan</a>
            @if(in_array(auth()->user()->role,['admin','owner']))
                <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><span class="nav-icon">▦</span>Produk & stok</a>
                <a class="{{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}" href="{{ route('admin.accounts.index') }}"><span class="nav-icon">♙</span>Kelola akun</a>
            @endif
        </nav>
        <div class="admin-sidebar-bottom"><nav class="admin-menu"><a href="{{ route('shop.index') }}"><span class="nav-icon">↗</span>Lihat toko</a><form method="post" action="{{ route('logout') }}">@csrf<button type="submit" class="admin-link-button"><span class="nav-icon">⇥</span>Keluar</button></form></nav></div>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar"><button class="admin-toggle" onclick="document.querySelector('.admin-sidebar').scrollIntoView({behavior:'smooth'})">Menu</button><small>Panel pengelolaan toko</small><div class="admin-topbar-actions"><span class="admin-user">{{ auth()->user()->name }} · {{ ucfirst(auth()->user()->role) }}</span><form method="post" action="{{ route('logout') }}">@csrf<button class="topbar-logout" type="submit">Keluar</button></form></div></header>
        @if(session('success'))<div class="notice admin-flash">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="notice error admin-flash">{{ $errors->first() }}</div>@endif
        <main class="admin-content">@yield('content')</main>
    </div>
</div>
@stack('scripts')
</body></html>
