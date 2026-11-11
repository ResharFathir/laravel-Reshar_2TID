@php($displayName = $profile?->name ?: 'Reshar Fathir Zuhri')
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portofolio') — {{ $displayName }}</title>
    <script>
        (function () {
            var theme = 'dark';
            try { if (localStorage.getItem('portfolio-theme') === 'light') theme = 'light'; } catch (e) {}
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0b0d12; --surface:#13161e; --soft:#1a1e29; --line:rgba(255,255,255,.1); --text:#f2f3f7; --muted:#98a0b3; --accent:#ffb454; --accent-ink:#1a1100; --panel:var(--surface); --panel-soft:var(--soft); --mint:var(--accent); --bs-body-bg:var(--bg); --bs-body-color:var(--text); }
        :root[data-bs-theme=light] { --bg:#f6f5f1; --surface:#fff; --soft:#efede7; --line:rgba(20,22,28,.12); --text:#14161c; --muted:#5f6675; --accent:#b4520a; --accent-ink:#fff; }
        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; scroll-padding-top:88px; }
        body { min-height:100vh; margin:0; background:var(--bg); color:var(--text); font-family:'DM Sans',system-ui,sans-serif; -webkit-font-smoothing:antialiased; transition:background .25s,color .25s; }
        a { color:inherit; }
        :focus-visible { outline:2px solid var(--accent); outline-offset:3px; }
        .wrap { width:min(1200px,calc(100% - 40px)); margin-inline:auto; }
        .flow-wrap { width:min(860px,calc(100% - 32px)); margin-inline:auto; }

        .site-nav { position:sticky; top:0; z-index:40; border-bottom:1px solid var(--line); background:color-mix(in srgb,var(--bg) 80%,transparent); backdrop-filter:blur(16px); }
        .nav-inner { display:flex; min-height:72px; align-items:center; justify-content:space-between; gap:16px; }
        .brand { display:flex; align-items:center; gap:11px; text-decoration:none; font-family:'Syne',sans-serif; font-weight:700; }
        .brand-mark { display:grid; width:40px; height:40px; place-items:center; border-radius:12px; background:var(--accent); color:var(--accent-ink); font:800 .82rem 'Syne',sans-serif; }
        .nav-links { display:flex; align-items:center; gap:24px; }
        .nav-link-x { color:var(--muted); font-size:.92rem; font-weight:500; text-decoration:none; }
        .nav-link-x:hover { color:var(--text); }
        .icon-btn { display:grid; width:42px; height:42px; place-items:center; border:1px solid var(--line); border-radius:50%; background:transparent; color:var(--text); }
        .icon-btn:hover { border-color:var(--accent); }

        .btn-accent, .flow-button { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:.7rem 1.4rem; border:0; border-radius:999px; background:var(--accent); color:var(--accent-ink); font-weight:700; text-decoration:none; transition:transform .15s,filter .15s; }
        .btn-accent:hover, .flow-button:hover { color:var(--accent-ink); filter:brightness(1.08); transform:translateY(-1px); }
        .btn-soft, .flow-secondary { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:.7rem 1.3rem; border:1px solid var(--line); border-radius:999px; background:transparent; color:var(--text); font-weight:600; text-decoration:none; }
        .btn-soft:hover, .flow-secondary:hover { border-color:var(--accent); color:var(--text); }
        .flow-danger { border:1px solid rgba(255,107,129,.4); border-radius:999px; background:transparent; color:#ff6b81; }
        .flow-danger:hover { background:rgba(255,107,129,.1); color:#ff6b81; }

        .flow-main { padding:clamp(32px,6vw,64px) 0 80px; }
        .flow-heading { margin-bottom:28px; }
        .flow-eyebrow { color:var(--accent); font-size:.9rem; font-weight:600; }
        .flow-title { margin:8px 0 10px; font-family:'Syne',sans-serif; font-size:clamp(2.2rem,6vw,3.8rem); font-weight:800; letter-spacing:-.035em; line-height:1; }
        .flow-copy { color:var(--muted); line-height:1.7; }
        .flow-card { padding:clamp(22px,5vw,40px); border:1px solid var(--line); border-radius:28px; background:var(--surface); }
        .flow-label { margin-bottom:8px; font-size:.9rem; font-weight:600; }
        .flow-control { min-height:50px; border:1px solid var(--line); border-radius:14px; background:var(--soft); color:var(--text); }
        textarea.flow-control { min-height:130px; }
        .flow-control:focus { border-color:var(--accent); background:var(--soft); color:var(--text); box-shadow:0 0 0 4px color-mix(in srgb,var(--accent) 22%,transparent); }
        .flow-control::placeholder { color:var(--muted); opacity:.7; }
        .flow-control[type=file] { padding:11px; }
        .flow-control[type=file]::file-selector-button { margin:-5px 12px -5px -5px; padding:7px 14px; border:0; border-radius:999px; background:var(--accent); color:var(--accent-ink); font-weight:600; }
        .flow-hint { margin-top:6px; color:var(--muted); font-size:.83rem; }
        .flow-divider { margin:30px 0 20px; padding-bottom:12px; border-bottom:1px solid var(--line); font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; }
        .flow-preview { width:min(100%,520px); max-height:300px; border:1px solid var(--line); border-radius:20px; background:var(--soft); object-fit:cover; }
        .flow-link { color:var(--accent); overflow-wrap:anywhere; }
        .form-check-input:checked { border-color:var(--accent); background-color:var(--accent); }
        .alert { border-radius:16px; }

        .site-footer { padding:22px 0 34px; border-top:1px solid var(--line); color:var(--muted); font-size:.86rem; }
        .toast-note { position:fixed; right:20px; bottom:20px; z-index:60; padding:12px 18px; border:1px solid var(--line); border-radius:14px; background:var(--surface); box-shadow:0 12px 34px rgba(0,0,0,.25); opacity:0; pointer-events:none; transform:translateY(12px); transition:.2s; }
        .toast-note.show { opacity:1; transform:none; }
        @media (max-width:700px) { .nav-link-x, .brand-text { display:none; } .nav-links { gap:10px; } }
        @media (prefers-reduced-motion:reduce) { *, *::before, *::after { animation:none !important; transition:none !important; scroll-behavior:auto !important; } }
    </style>
    @stack('styles')
</head>
<body>
<nav class="site-nav">
    <div class="wrap nav-inner">
        <a href="{{ route('portofolio.index') }}" class="brand">
            <span class="brand-mark">RFZ</span><span class="brand-text">{{ $displayName }}</span>
        </a>
        <div class="nav-links">
            <a class="nav-link-x" href="{{ route('portofolio.index') }}#profil">Profil</a>
            <a class="nav-link-x" href="{{ route('portofolio.index') }}#karya">Karya</a>
            <a class="nav-link-x" href="{{ route('portofolio.index') }}#keahlian">Keahlian</a>
            <button class="icon-btn" id="themeToggle" type="button" aria-label="Ganti tema" title="Ganti tema">☼</button>
            <a href="{{ route('portofolio.create') }}" class="btn-accent btn-sm">＋ <span class="d-none d-sm-inline">Tambah proyek</span></a>
        </div>
    </div>
</nav>

@hasSection('full')
    @yield('full')
@else
    <main class="flow-wrap flow-main">
        @yield('content')
    </main>
@endif

<footer class="site-footer">
    <div class="wrap d-flex justify-content-between flex-wrap gap-2">
        <span>© {{ now()->year }} {{ $displayName }}</span>
        <span>Dibuat dengan Laravel.</span>
    </div>
</footer>
<div class="toast-note" id="toastNote" role="status" aria-live="polite"></div>

<script>
    const themeToggle = document.getElementById('themeToggle');
    const root = document.documentElement;
    const paintToggle = () => themeToggle.textContent = root.getAttribute('data-bs-theme') === 'light' ? '☾' : '☼';
    paintToggle();
    themeToggle.addEventListener('click', () => {
        const next = root.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
        root.setAttribute('data-bs-theme', next);
        try { localStorage.setItem('portfolio-theme', next); } catch (e) {}
        paintToggle();
    });

    const toastNote = document.getElementById('toastNote');
    let toastTimer;
    function showToast(message) {
        toastNote.textContent = message;
        toastNote.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toastNote.classList.remove('show'), 2400);
    }
</script>
@stack('scripts')
</body>
</html>