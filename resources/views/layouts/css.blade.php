<!-- Volt CSS -->
<link type="text/css" href="{{ asset('assets-admin/css/volt.css') }}" rel="stylesheet">
<style>
    :root { --admin-ink:#172338; --admin-muted:#738096; --admin-accent:#12a982; --admin-line:#e8edf3; --admin-canvas:#f5f7fb; }
    body { background:var(--admin-canvas); color:var(--admin-ink); font-family:Inter,"Instrument Sans",system-ui,sans-serif; }
    .content { padding:0 34px 24px; min-height:100vh; }
    .sidebar { background:#172338!important; box-shadow:8px 0 30px rgba(20,36,58,.06); }
    .sidebar-inner { display:flex; flex-direction:column; min-height:100vh; }
    .admin-brand { padding:5px 7px; letter-spacing:-.02em; }
    .admin-brand strong { font-size:1rem; }
    .admin-brand small,.sidebar-portfolio small { display:block; margin-top:3px; color:#98a7bc; font-size:.73rem; }
    .admin-brand-mark { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:14px; background:linear-gradient(145deg,#39d3ad,#0d9c7e); color:#fff; font-size:1.15rem; font-weight:800; box-shadow:0 7px 18px #0d9c7e44; }
    .sidebar-label { padding:0 11px; color:#8190a6; font-size:.65rem; font-weight:800; letter-spacing:.12em; }
    #sidebarMenu .nav-link { display:flex; align-items:center; gap:12px; min-height:46px; padding:10px 12px; border-radius:12px; color:#b8c3d1; font-weight:600; transition:background .2s,color .2s,transform .2s; }
    #sidebarMenu .nav-link:hover { background:#ffffff12; color:#fff; transform:translateX(2px); }
    #sidebarMenu .nav-item.active .nav-link { background:linear-gradient(100deg,#ffffff1b,#ffffff0c); color:#fff; box-shadow:inset 3px 0 #39d3ad; }
    #sidebarMenu .sidebar-icon { display:inline-flex; align-items:center; justify-content:center; width:23px; color:#91a0b5; }
    #sidebarMenu .nav-item.active .sidebar-icon { color:#48d9b5; }
    .sidebar-bottom { margin-top:auto; padding:24px 4px 10px; }
    .sidebar-portfolio { display:flex; align-items:center; gap:11px; padding:13px; border:1px solid #ffffff18; border-radius:14px; color:#fff; text-decoration:none; background:#ffffff0a; }
    .sidebar-portfolio:hover { color:#fff; background:#ffffff14; }
    .sidebar-portfolio-icon { display:grid; place-items:center; width:34px; height:34px; border-radius:10px; background:#ffffff18; color:#55dfbd; font-size:1.15rem; }
    .sidebar-portfolio strong { font-size:.82rem; }
    .admin-topbar { min-height:92px; margin-bottom:10px; border-bottom:1px solid var(--admin-line); }
    .topbar-eyebrow { color:var(--admin-muted); font-size:.65rem; font-weight:800; letter-spacing:.13em; }
    .topbar-title { margin-top:3px; color:var(--admin-ink); font-size:1.15rem; font-weight:750; letter-spacing:-.03em; }
    .topbar-title span { color:#e9a93e; }
    .topbar-date { color:var(--admin-muted); font-size:.8rem; }
    .topbar-site-link { border-radius:10px; font-weight:650; }
    .content > .py-4 { padding-top:30px!important; padding-bottom:22px!important; }
    .content > .py-4 > .d-flex { align-items:center; }
    .content h1.h4 { color:var(--admin-ink); font-size:1.55rem; font-weight:750; letter-spacing:-.035em; }
    .content .py-4 p { color:var(--admin-muted); font-size:.93rem; }
    .content .btn { border-radius:10px; font-weight:650; transition:transform .18s,box-shadow .18s; }
    .content .btn-success,.content .btn-primary,.content .btn-outline-primary { display:inline-flex; align-items:center; justify-content:center; width:auto; min-height:42px; padding:9px 17px; white-space:nowrap; }
    .content .btn:hover { transform:translateY(-1px); }
    .content .btn-success { border-color:var(--admin-accent); background:var(--admin-accent); box-shadow:0 5px 12px #12a98227; }
    .content .btn-info { border-color:#3975e8; background:#3975e8; color:#fff; }
    .content .card { overflow:hidden; border:1px solid var(--admin-line)!important; border-radius:17px; background:#fff; box-shadow:0 8px 28px rgba(32,54,82,.045)!important; }
    .content .card-body { padding:24px; }
    .content .table-responsive { border-radius:12px; }
    .content table { margin-bottom:0; }
    .content .table thead th { padding:15px 16px; border-bottom:1px solid var(--admin-line); background:#f7f9fc; color:#68768b; font-size:.7rem; font-weight:800; letter-spacing:.07em; text-transform:uppercase; white-space:nowrap; }
    .content .table tbody td { padding:16px; border-color:#edf0f4; color:#26364d; vertical-align:middle; }
    .content .table tbody tr:last-child td { border-bottom:0; }
    .content .table tbody tr:hover { background:#fafcff; }
    .content .table .btn { padding:7px 11px; }
    .content .form-label { color:#36465c; font-size:.84rem; font-weight:700; }
    .content .form-control,.content .form-select { min-height:44px; border-color:#dfe5ec; border-radius:10px; color:#25364d; box-shadow:none; }
    .content .form-control:focus,.content .form-select:focus { border-color:#32bd9b; box-shadow:0 0 0 3px #12a9821a; }
    .content .alert { border:0; border-radius:12px; }
    .admin-footer { display:flex; justify-content:space-between; gap:12px; margin-top:38px; padding:21px 3px 4px; border-top:1px solid var(--admin-line); color:var(--admin-muted); font-size:.79rem; }
    .admin-footer strong { color:#33435a; }
    @media (max-width:991.98px) { .content { padding:0 22px 22px; } .sidebar { z-index:1050; } .admin-topbar { min-height:78px; } }
    @media (max-width:575.98px) { .content { padding:0 15px 18px; } .content .card-body { padding:16px; } .admin-footer { flex-direction:column; } .content > .py-4 > .d-flex { align-items:flex-start!important; gap:12px; } .topbar-site-link { font-size:.74rem; } }
</style>