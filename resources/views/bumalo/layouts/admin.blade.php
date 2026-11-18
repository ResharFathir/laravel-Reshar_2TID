<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') – Bumalo.id</title>
    @include('bumalo.layouts.css')
    <style>
        body{display:grid;grid-template-columns:220px 1fr;min-height:100vh}
        .side{background:#111;color:#fff;padding:24px 16px;display:flex;flex-direction:column;gap:6px}
        .side .logo{color:#fff;margin-bottom:18px}
        .side a:not(.logo),.side button{color:#ddd;padding:9px 12px;border-radius:8px;background:none;border:0;text-align:left;font:inherit;cursor:pointer;width:100%}
        .side a.on,.side a:not(.logo):hover,.side button:hover{background:#222;color:#fff}
        .wrap{padding:28px;max-width:1000px;width:100%}
        .wrap h1{font-size:44px;margin-bottom:18px}
        .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px}
        .stat{background:var(--soft);padding:18px;border-radius:12px}.stat b{display:block;font:800 40px 'Barlow Condensed',sans-serif}
        table{width:100%;border-collapse:collapse}th,td{padding:10px 8px;border-bottom:1px solid var(--line);text-align:left}
        .btn{display:inline-block;background:#111;color:#fff;border:0;border-radius:99px;padding:9px 20px;font:600 14px Inter,sans-serif;cursor:pointer}
        .btn.out{background:none;color:#111;border:1.5px solid #111}.btn.danger{background:#c0392b}
        .form{display:grid;grid-template-columns:1fr 1fr;gap:14px}.form .full{grid-column:1/-1}
        .form label{display:flex;flex-direction:column;gap:4px;font-weight:600;font-size:14px}
        .form input,.form select{padding:10px;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg);color:var(--ink)}
        .ok{background:#e6f6ea;color:#1b5e20;padding:10px 14px;border-radius:8px;margin-bottom:16px}
        .err{color:#c0392b;font-size:13px;font-weight:400}
        @media(max-width:760px){body{grid-template-columns:1fr}.stats{grid-template-columns:1fr}.form{grid-template-columns:1fr}}
    </style>
</head>
<body>
    @include('bumalo.layouts.sidebar')
    <div class="wrap">
        @if (session('success'))<div class="ok">{{ session('success') }}</div>@endif
        @yield('content')
    </div>
</body>
</html>
