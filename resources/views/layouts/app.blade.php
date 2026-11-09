<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Reshar Fathir Zuhri</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --ink: #0b2b2a;
            --ink-soft: #123f3c;
            --brand: #0f9d84;
            --brand-dark: #0a7d69;
            --brand-tint: #e3f6f1;
            --gold: #e9b44c;
            --bg: #f3f6f5;
            --line: #e2e9e7;
            --text: #16302e;
            --muted: #6b8280;
            --sidebar-w: 268px;
            --bs-primary: var(--brand);
            --bs-primary-rgb: 15, 157, 132;
            --bs-body-font-family: 'DM Sans', system-ui, sans-serif;
            --bs-body-color: var(--text);
            --bs-border-color: var(--line);
        }

        html { scroll-behavior: smooth; }
        body { background: var(--bg); color: var(--text); font-family: 'DM Sans', system-ui, sans-serif; min-height: 100vh; }
        h1, h2, h3, h4, .h4, .brand-name { font-family: 'Bricolage Grotesque', 'DM Sans', sans-serif; letter-spacing: -.02em; }
        a { color: var(--brand-dark); }
        :focus-visible { outline: 3px solid rgba(233, 180, 76, .7); outline-offset: 2px; }

        /* ---------- Sidebar ---------- */
        .sidebar {
            position: fixed; inset: 0 auto 0 0; width: var(--sidebar-w); z-index: 1040;
            display: flex; flex-direction: column; padding: 26px 18px 20px;
            background: linear-gradient(175deg, var(--ink) 0%, var(--ink-soft) 100%);
            color: #cfe3df; transition: transform .25s ease;
        }
        .brand { display: flex; align-items: center; gap: 12px; padding: 0 8px 26px; text-decoration: none; color: #fff; }
        .brand-mark {
            display: grid; place-items: center; width: 44px; height: 44px; border-radius: 14px;
            background: var(--gold); color: var(--ink); font: 800 1.05rem 'Bricolage Grotesque', sans-serif;
        }
        .brand-name { display: block; font-size: 1.05rem; font-weight: 700; line-height: 1.15; }
        .brand-sub { display: block; font-size: .72rem; color: #8fb3ad; }
        .nav-group { margin: 6px 8px 8px; font-size: .74rem; font-weight: 600; color: #7fa39d; }
        .side-link {
            position: relative; display: flex; align-items: center; gap: 12px; padding: 11px 14px; margin-bottom: 4px;
            border-radius: 12px; color: #cfe3df; font-weight: 500; text-decoration: none; transition: background .15s, color .15s;
        }
        .side-link svg { width: 20px; height: 20px; flex: 0 0 20px; }
        .side-link:hover { background: rgba(255, 255, 255, .07); color: #fff; }
        .side-link.active { background: rgba(15, 157, 132, .22); color: #fff; }
        .side-link.active::before {
            content: ""; position: absolute; left: -18px; top: 10px; bottom: 10px; width: 4px; border-radius: 0 4px 4px 0; background: var(--gold);
        }
        .side-foot { margin-top: auto; padding: 14px; border-radius: 14px; background: rgba(255, 255, 255, .06); font-size: .8rem; }
        .side-foot strong { display: block; color: #fff; font-size: .86rem; }

        /* ---------- Main ---------- */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            position: sticky; top: 0; z-index: 1030; display: flex; align-items: center; gap: 14px;
            padding: 14px 32px; background: rgba(243, 246, 245, .88); backdrop-filter: blur(10px); border-bottom: 1px solid var(--line);
        }
        .menu-btn { display: none; border: 1px solid var(--line); background: #fff; border-radius: 10px; width: 42px; height: 42px; }
        .topbar-title { font: 700 1.05rem 'Bricolage Grotesque', sans-serif; margin: 0; }
        .user-chip { margin-left: auto; display: flex; align-items: center; gap: 10px; padding: 5px 14px 5px 5px; border: 1px solid var(--line); border-radius: 999px; background: #fff; }
        .avatar { display: grid; place-items: center; width: 34px; height: 34px; border-radius: 50%; background: var(--ink); color: var(--gold); font-weight: 700; font-size: .78rem; }
        .user-chip small { display: block; color: var(--muted); font-size: .7rem; line-height: 1; }
        .user-chip span.name { font-weight: 600; font-size: .86rem; line-height: 1.2; }
        .content { flex: 1; padding: 12px 32px 32px; }
        .site-footer { padding: 18px 32px; border-top: 1px solid var(--line); color: var(--muted); font-size: .82rem; }

        /* ---------- Restyle Bootstrap components used by the views ---------- */
        .card { border: 1px solid var(--line) !important; border-radius: 18px; box-shadow: 0 10px 30px rgba(11, 43, 42, .05) !important; background: #fff; }
        .card-body { padding: 1.5rem; }
        .breadcrumb { font-size: .82rem; }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--muted); }
        .breadcrumb-item a { color: var(--muted); text-decoration: none; }
        .breadcrumb-item.active { color: var(--text); font-weight: 600; }
        .icon { width: 18px; height: 18px; }
        .icon-xxs { width: 16px; height: 16px; }
        .icon-xs { width: 16px; height: 16px; }
        h1.h4 { font-size: 1.6rem; font-weight: 800; }

        .btn { border-radius: 11px; font-weight: 600; padding: .55rem 1.05rem; border-width: 1px; transition: transform .15s, box-shadow .15s, background .15s; }
        .btn:active { transform: translateY(1px); }
        .btn-sm { padding: .38rem .75rem; font-size: .8rem; border-radius: 9px; }
        .btn-primary, .btn-success { background: var(--brand); border-color: var(--brand); color: #fff !important; }
        .btn-primary:hover, .btn-success:hover { background: var(--brand-dark); border-color: var(--brand-dark); box-shadow: 0 8px 18px rgba(15, 157, 132, .28); }
        .btn-outline-primary { color: var(--brand-dark); border-color: var(--brand); }
        .btn-outline-primary:hover { background: var(--brand); border-color: var(--brand); }
        .btn-outline-secondary { color: var(--muted); border-color: var(--line); background: #fff; }
        .btn-outline-secondary:hover { background: var(--bg); color: var(--text); border-color: var(--line); }
        .btn-info { background: var(--brand-tint); border-color: var(--brand-tint); color: var(--brand-dark) !important; }
        .btn-info:hover { background: #cdeee6; border-color: #cdeee6; }
        .btn-danger { background: #fdecea; border-color: #fdecea; color: #c0392b !important; }
        .btn-danger:hover { background: #fadbd7; border-color: #fadbd7; }

        .form-label { font-weight: 600; font-size: .86rem; }
        .form-control, .form-select { border: 1px solid #d5dfdd; border-radius: 11px; padding: .65rem .9rem; background-color: #fbfdfc; }
        .form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 4px rgba(15, 157, 132, .15); background: #fff; }

        .alert { border: 0; border-radius: 14px; padding: .9rem 1.1rem; }
        .alert-success { background: var(--brand-tint); color: var(--brand-dark); }
        .alert-danger { background: #fdecea; color: #a93226; }

        .table { --bs-table-bg: transparent; margin: 0; }
        .table thead th {
            background: #f1f6f5; color: var(--muted); font-size: .76rem; font-weight: 700; letter-spacing: .02em;
            padding: .85rem 1rem; border: 0; white-space: nowrap;
        }
        .table thead th:first-child { border-radius: 12px 0 0 12px; }
        .table thead th:last-child { border-radius: 0 12px 12px 0; }
        .table td { padding: 1rem; border-color: var(--line); vertical-align: middle; }
        .table tbody tr { transition: background .15s; }
        .table tbody tr:hover { background: #f8fbfa; }
        .table tbody tr:last-child td { border-bottom: 0; }

        /* ---------- Mobile ---------- */
        .backdrop { display: none; position: fixed; inset: 0; background: rgba(11, 43, 42, .5); z-index: 1035; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: none; }
            .sidebar.open + .backdrop { display: block; }
            .main { margin-left: 0; }
            .menu-btn { display: grid; place-items: center; }
            .topbar, .content, .site-footer { padding-left: 18px; padding-right: 18px; }
            .user-chip .who { display: none; }
            .user-chip { padding: 5px; }
        }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; scroll-behavior: auto !important; } }
    </style>
    @stack('styles')
</head>
<body>

    <aside class="sidebar" id="sidebar" aria-label="Menu utama">
        <a href="{{ route('dashboard') }}" class="brand">
            <span class="brand-mark">RFZ</span>
            <span>
                <span class="brand-name">Reshar Fathir Zuhri</span>
                <span class="brand-sub">Ruang kerja admin</span>
            </span>
        </a>

        <div class="nav-group">Menu</div>
        <nav>
            <a href="{{ route('dashboard') }}" class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-8 9 8M5 10v10h5v-6h4v6h5V10"/></svg>
                Dashboard
            </a>
            <a href="{{ route('pelanggan.index') }}" class="side-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2M10 10a4 4 0 100-8 4 4 0 000 8zM21 20v-2a4 4 0 00-3-3.9M16 2.1a4 4 0 010 7.8"/></svg>
                Data pelanggan
            </a>
            <a href="{{ route('admin.user.index') }}" class="side-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 3v6c0 4.5-3.2 8.2-8 9-4.8-.8-8-4.5-8-9V6l8-3z"/></svg>
                Manajemen user
            </a>
            @if (Route::has('portofolio.index'))
                <a href="{{ route('portofolio.index') }}" class="side-link {{ request()->routeIs('portofolio.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18v12H3zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    Portofolio
                </a>
            @endif
        </nav>

        <div class="side-foot">
            <strong>Reshar Fathir Zuhri</strong>
            Pemilik dan pengelola aplikasi ini.
        </div>
    </aside>
    <div class="backdrop" id="backdrop"></div>

    <div class="main">
        <header class="topbar">
            <button class="menu-btn" id="menuBtn" type="button" aria-label="Buka menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <h2 class="topbar-title">@yield('title', 'Dashboard')</h2>

            <div class="user-chip">
                <span class="avatar">RF</span>
                <span class="who">
                    <span class="name">{{ auth()->user()->name ?? 'Reshar Fathir Zuhri' }}</span>
                    <small>Administrator</small>
                </span>
            </div>
            @if (Route::has('logout') && auth()->check())
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Keluar</button>
                </form>
            @endif
        </header>

        <main class="content">
            @yield('content')
        </main>

        <footer class="site-footer">
            &copy; {{ date('Y') }} Reshar Fathir Zuhri. Seluruh hak cipta dilindungi.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var sidebar = document.getElementById('sidebar');
            var toggle = function () { sidebar.classList.toggle('open'); };
            document.getElementById('menuBtn').addEventListener('click', toggle);
            document.getElementById('backdrop').addEventListener('click', toggle);
        })();
    </script>
    @stack('scripts')
</body>
</html>