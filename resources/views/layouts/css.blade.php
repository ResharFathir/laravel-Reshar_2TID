<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@if (file_exists(public_path('assets-admin/css/volt.css')))
    <link type="text/css" href="{{ asset('assets-admin/css/volt.css') }}" rel="stylesheet">
@else
    {{-- Cadangan: dipakai kalau folder public/assets-admin tidak ada --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .icon { width: 20px; height: 20px; }
        .icon-xxs { width: 16px; height: 16px; }
        .icon-xs { width: 18px; height: 18px; }
        .icon-sm { width: 22px; height: 22px; }
        .navbar-brand { text-decoration: none; }
        .content { padding: 0 16px 24px; }
        .sidebar .nav-link { display: flex; align-items: center; text-decoration: none; }
        .sidebar-icon { display: inline-flex; }
        .collapse-close svg { color: #fff; }
        .font-small { font-size: .875rem; }
        @media (min-width: 992px) {
            .sidebar { position: fixed; top: 0; bottom: 0; left: 0; z-index: 1040; width: 268px; overflow-y: auto; }
            .content { margin-left: 268px; padding: 0 28px 28px; }
        }
    </style>
@endif

<style>
    :root {
        --rfz-ink: #0b2b2a;
        --rfz-ink-soft: #123f3c;
        --rfz-brand: #0f9d84;
        --rfz-brand-dark: #0a7d69;
        --rfz-tint: #e3f6f1;
        --rfz-gold: #e9b44c;
        --rfz-bg: #f3f6f5;
        --rfz-line: #e2e9e7;
        --rfz-muted: #6b8280;
    }
    body { background: var(--rfz-bg); font-family: 'DM Sans', system-ui, sans-serif; color: #16302e; }
    h1, h2, h3, h4, .h1, .h2, .h3, .h4 { font-family: 'Bricolage Grotesque', 'DM Sans', sans-serif; letter-spacing: -.02em; }
    h1.h4 { font-size: 1.6rem; font-weight: 800; }
    a { color: var(--rfz-brand-dark); }
    :focus-visible { outline: 3px solid rgba(233, 180, 76, .7); outline-offset: 2px; }

    /* ---------- Sidebar ---------- */
    .sidebar, .navbar-theme-primary { background: linear-gradient(175deg, var(--rfz-ink), var(--rfz-ink-soft)) !important; }
    .rfz-brand { display: flex; align-items: center; gap: 12px; padding: 8px 6px 22px; color: #fff; text-decoration: none; }
    .rfz-brand:hover { color: #fff; }
    .rfz-mark { display: grid; flex: 0 0 42px; width: 42px; height: 42px; place-items: center; border-radius: 13px; background: var(--rfz-gold); color: var(--rfz-ink); font: 800 .9rem 'Bricolage Grotesque', sans-serif; }
    .rfz-brand strong { display: block; font: 700 1rem/1.15 'Bricolage Grotesque', sans-serif; }
    .rfz-brand small { color: #8fb3ad; font-size: .72rem; }
    .rfz-group { margin: 6px 8px 8px; color: #7fa39d; font-size: .74rem; font-weight: 600; }
    .sidebar .nav-item .nav-link { margin-bottom: 4px; padding: .7rem 1rem; border-radius: 12px; color: #cfe3df; font-weight: 500; transition: background .15s, color .15s; }
    .sidebar .nav-item .nav-link:hover { background: rgba(255, 255, 255, .07); color: #fff; }
    .sidebar .nav-item.active > .nav-link { background: rgba(15, 157, 132, .26); color: #fff; box-shadow: inset 3px 0 0 var(--rfz-gold); }
    .sidebar .sidebar-icon { color: inherit; }
    .rfz-owner { margin-top: 28px; padding: 14px; border-radius: 14px; background: rgba(255, 255, 255, .06); color: #a9c5c0; font-size: .8rem; }
    .rfz-owner strong { display: block; color: #fff; font-size: .86rem; }

    /* ---------- Top bar ---------- */
    .navbar-top { position: sticky; top: 0; z-index: 1020; margin-bottom: 8px; padding: 12px 0 !important; background: rgba(243, 246, 245, .9) !important; backdrop-filter: blur(10px); border-bottom: 1px solid var(--rfz-line); }
    .rfz-hello { margin: 0; font: 700 1.05rem 'Bricolage Grotesque', sans-serif; }
    .rfz-hello small { display: block; color: var(--rfz-muted); font: 400 .78rem 'DM Sans', sans-serif; }
    .rfz-avatar { display: grid; width: 38px; height: 38px; place-items: center; border-radius: 50%; background: var(--rfz-ink); color: var(--rfz-gold); font-weight: 700; font-size: .8rem; }
    .rfz-user { display: flex; align-items: center; gap: 10px; padding: 4px 14px 4px 4px; border: 1px solid var(--rfz-line); border-radius: 999px; background: #fff; color: #16302e; text-decoration: none; }

    /* ---------- Components used by the pages ---------- */
    .card { border: 1px solid var(--rfz-line) !important; border-radius: 18px !important; box-shadow: 0 10px 30px rgba(11, 43, 42, .05) !important; }
    .breadcrumb-item a { color: var(--rfz-muted); }
    .btn { border-radius: 11px; font-weight: 600; transition: transform .15s, box-shadow .15s; }
    .btn:active { transform: translateY(1px); }
    .btn-primary, .btn-success { background: var(--rfz-brand) !important; border-color: var(--rfz-brand) !important; color: #fff !important; }
    .btn-primary:hover, .btn-success:hover { background: var(--rfz-brand-dark) !important; border-color: var(--rfz-brand-dark) !important; box-shadow: 0 8px 18px rgba(15, 157, 132, .28); }
    .btn-outline-primary { color: var(--rfz-brand-dark); border-color: var(--rfz-brand); }
    .btn-outline-primary:hover { background: var(--rfz-brand); border-color: var(--rfz-brand); color: #fff; }
    .btn-info { background: var(--rfz-tint) !important; border-color: var(--rfz-tint) !important; color: var(--rfz-brand-dark) !important; }
    .btn-danger { background: #fdecea !important; border-color: #fdecea !important; color: #c0392b !important; }
    .form-control, .form-select { border: 1px solid #d5dfdd; border-radius: 11px; background-color: #fbfdfc; }
    .form-control:focus, .form-select:focus { border-color: var(--rfz-brand); box-shadow: 0 0 0 4px rgba(15, 157, 132, .15); background: #fff; }
    .form-label { font-weight: 600; font-size: .86rem; }
    .alert-success { border: 0; border-radius: 14px; background: var(--rfz-tint); color: var(--rfz-brand-dark); }
    .alert-danger { border: 0; border-radius: 14px; }
    .table thead th { background: #f1f6f5 !important; color: var(--rfz-muted); font-size: .76rem; font-weight: 700; border: 0; }
    .table td { vertical-align: middle; border-color: var(--rfz-line); }
    .table tbody tr:hover { background: #f8fbfa; }
</style>