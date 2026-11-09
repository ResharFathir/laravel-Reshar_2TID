@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="dashboard-welcome py-4">
        <span class="dashboard-kicker">RINGKASAN RUANG KERJA</span>
        <h1 class="h4 mt-2 mb-2">Semua yang penting, dalam satu tempat.</h1>
        <p class="mb-0">Kelola pelanggan dan akses pengguna dengan lebih praktis.</p>
    </section>

    <div class="row g-4 dashboard-cards">
        <div class="col-md-6">
            <a class="dashboard-card" href="{{ route('pelanggan.index') }}">
                <span class="dashboard-card-icon dashboard-card-icon-green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.7a9 9 0 003.7-.5 3 3 0 00-4.7-2.7M18 18.7v.7A12 12 0 0112 21a12 12 0 01-6-1.6v-.7a6 6 0 0112 0zM15 6.75a3 3 0 11-6 0 3 3 0 016 0zM6 18.7a6 6 0 01.9-3.2 3 3 0 00-4.6 2.7 9 9 0 003.7.5z"></path></svg></span>
                <span class="dashboard-card-copy"><strong>Data Pelanggan</strong><small>Lihat dan perbarui informasi pelanggan.</small></span>
                <span class="dashboard-card-arrow" aria-hidden="true">↗</span>
            </a>
        </div>
        <div class="col-md-6">
            <a class="dashboard-card" href="{{ route('admin.user.index') }}">
                <span class="dashboard-card-icon dashboard-card-icon-blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.9M14 3.1a4 4 0 010 7.8M14 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
                <span class="dashboard-card-copy"><strong>Manajemen User</strong><small>Atur akun yang memiliki akses ke sistem.</small></span>
                <span class="dashboard-card-arrow" aria-hidden="true">↗</span>
            </a>
        </div>
    </div>

    <section class="dashboard-tip mt-4">
        <span class="dashboard-tip-icon" aria-hidden="true">✦</span>
        <div><strong>Ruang kerja lebih rapi</strong><p class="mb-0">Gunakan menu di samping untuk berpindah antara data pelanggan dan akun pengguna.</p></div>
    </section>

    <style>
        .dashboard-welcome { padding-top:34px!important; }
        .dashboard-kicker { color:#12a982; font-size:.68rem; font-weight:800; letter-spacing:.14em; }
        .dashboard-welcome h1 { font-size:clamp(1.45rem,2.7vw,2rem)!important; }
        .dashboard-cards { margin-top:10px; }
        .dashboard-card { display:flex; align-items:center; gap:17px; min-height:145px; padding:24px; border:1px solid #e8edf3; border-radius:17px; background:#fff; box-shadow:0 8px 28px rgba(32,54,82,.045); color:#172338; text-decoration:none; transition:transform .2s,box-shadow .2s,border-color .2s; }
        .dashboard-card:hover { transform:translateY(-3px); border-color:#bcebdd; box-shadow:0 15px 32px rgba(32,54,82,.09); color:#172338; }
        .dashboard-card-icon { display:grid; flex:0 0 52px; width:52px; height:52px; place-items:center; border-radius:15px; }
        .dashboard-card-icon svg { width:25px; height:25px; }
        .dashboard-card-icon-green { background:#e6f8f2; color:#0d9c7e; }
        .dashboard-card-icon-blue { background:#edf2ff; color:#5274df; }
        .dashboard-card-copy { display:grid; gap:5px; }
        .dashboard-card-copy strong { font-size:1rem; }
        .dashboard-card-copy small { color:#738096; font-size:.82rem; line-height:1.5; }
        .dashboard-card-arrow { margin-left:auto; color:#9aa7b8; font-size:1.15rem; }
        .dashboard-tip { display:flex; align-items:flex-start; gap:13px; padding:20px; border:1px solid #e5eee9; border-radius:15px; background:linear-gradient(110deg,#f0fbf7,#f7faff); }
        .dashboard-tip-icon { display:grid; width:32px; height:32px; flex:0 0 32px; place-items:center; border-radius:10px; background:#dff7ee; color:#0d9c7e; }
        .dashboard-tip strong { color:#26364d; font-size:.88rem; }
        .dashboard-tip p { margin-top:4px; color:#738096; font-size:.82rem; }
        @media(max-width:575.98px) { .dashboard-card { min-height:120px; padding:18px; } }
    </style>
@endsection