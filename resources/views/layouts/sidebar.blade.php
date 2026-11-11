@php($ownerName = 'Reshar Fathir Zuhri')

{{-- Navbar atas (khusus layar kecil) --}}
<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5 d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
        <span class="rfz-mark" style="flex-basis:36px;width:36px;height:36px">RFZ</span>
        <span class="text-white fw-bold">{{ $ownerName }}</span>
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

{{-- Sidebar --}}
<nav id="sidebarMenu" class="sidebar d-lg-block text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">

        <div class="user-card d-flex d-md-none align-items-center justify-content-between pb-4">
            <div class="d-flex align-items-center gap-3">
                <span class="rfz-avatar" style="width:52px;height:52px">RF</span>
                <div>
                    <h2 class="h5 mb-2 text-white">Halo, Reshar</h2>
                    @if (Route::has('logout'))
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">Keluar</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Tutup menu">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <a href="{{ route('dashboard') }}" class="rfz-brand d-none d-md-flex">
            <span class="rfz-mark">RFZ</span>
            <span><strong>{{ $ownerName }}</strong><small>Ruang kerja admin</small></span>
        </a>

        <div class="rfz-group">Menu</div>
        <ul class="nav flex-column pt-1">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                <a href="{{ route('pelanggan.index') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.13a9.1 9.1 0 003.74-.48 3 3 0 00-4.68-2.72M15 19.13V19.13a6 6 0 00-12 0M15 19.13a11.9 11.9 0 01-6 1.37 11.9 11.9 0 01-6-1.37M12 6.75a3 3 0 11-6 0 3 3 0 016 0zm8.25 2.25a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Pelanggan</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <a href="{{ route('admin.user.index') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 3v6c0 4.5-3.2 8.2-8 9-4.8-.8-8-4.5-8-9V6l8-3z"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">User</span>
                </a>
            </li>

            @if (Route::has('portofolio.index'))
                <li class="nav-item {{ request()->routeIs('portofolio.*') ? 'active' : '' }}">
                    <a href="{{ route('portofolio.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <svg class="icon icon-xs me-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18v12H3zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                            </svg>
                        </span>
                        <span class="sidebar-text">Portofolio</span>
                    </a>
                </li>
            @endif
        </ul>

        <div class="rfz-owner">
            <strong>{{ $ownerName }}</strong>
            Pemilik dan pengelola aplikasi ini.
        </div>
    </div>
</nav>