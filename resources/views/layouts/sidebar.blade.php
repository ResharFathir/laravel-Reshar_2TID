<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand" href="{{ route('dashboard') }}"><span class="admin-brand-mark">O</span> Omar Studio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Buka navigasi"><span class="navbar-toggler-icon"></span></button>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-3 pt-4">
        <a href="{{ route('dashboard') }}" class="admin-brand d-flex align-items-center gap-3 mb-5 text-decoration-none text-white">
            <span class="admin-brand-mark">O</span>
            <span><strong class="d-block">Omar Studio</strong><small>Ruang kerja admin</small></span>
        </a>
        <div class="sidebar-label mb-2">MENU UTAMA</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="{{ route('dashboard') }}" class="nav-link"><span class="sidebar-icon"><svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg></span><span class="sidebar-text">Dashboard</span></a></li>
            <li class="nav-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}"><a href="{{ route('pelanggan.index') }}" class="nav-link"><span class="sidebar-icon"><svg class="icon icon-xs" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9 9 0 003.7-.5 3 3 0 00-4.7-2.7M18 18.7v.7A12 12 0 0112 21a12 12 0 01-6-1.6v-.7a6 6 0 0112 0zM15 6.75a3 3 0 11-6 0 3 3 0 016 0zM6 18.7a6 6 0 01.9-3.2 3 3 0 00-4.6 2.7 9 9 0 003.7.5zM6 9.75a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM22.5 9.75a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path></svg></span><span class="sidebar-text">Pelanggan</span></a></li>
            <li class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}"><a href="{{ route('admin.user.index') }}" class="nav-link"><span class="sidebar-icon"><svg class="icon icon-xs" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.9M14 3.1a4 4 0 010 7.8M14 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span><span class="sidebar-text">User</span></a></li>
        </ul>
        <div class="sidebar-bottom mt-auto">
            <a href="{{ route('portofolio.index') }}" class="sidebar-portfolio"><span class="sidebar-portfolio-icon">↗</span><span><strong>Lihat portofolio</strong><small>Buka situs publik</small></span></a>
        </div>
    </div>
</nav>