<nav class="navbar navbar-top navbar-expand navbar-dashboard admin-topbar ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <span class="topbar-eyebrow">AREA ADMINISTRATOR</span>
                <p class="topbar-title mb-0">Halo, {{ auth()->user()?->name ?? 'Teman' }} <span aria-hidden="true">✦</span></p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="topbar-date d-none d-sm-inline">{{ now()->translatedFormat('l, d F Y') }}</span>
                <a href="{{ route('portofolio.index') }}" class="btn btn-outline-primary btn-sm topbar-site-link">Lihat situs <span aria-hidden="true">↗</span></a>
            </div>
        </div>
    </div>
</nav>