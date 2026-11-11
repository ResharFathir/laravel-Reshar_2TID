@php($headerName = auth()->user()->name ?? 'Reshar Fathir Zuhri')

<nav class="navbar navbar-top navbar-expand navbar-dashboard ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center w-100" id="navbarSupportedContent">

            <div class="rfz-hello">
                Halo, {{ \Illuminate\Support\Str::before($headerName, ' ') }}
                <small>{{ now()->translatedFormat('l, d F Y') }}</small>
            </div>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="rfz-user">
                            <span class="rfz-avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($headerName, 0, 2)) }}</span>
                            <span class="d-none d-lg-inline fw-bold font-small">{{ $headerName }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                        @if (Route::has('portofolio.index'))
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('portofolio.index') }}">Portofolio saya</a>
                        @endif
                        @if (Route::has('profile.edit'))
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">Profil</a>
                        @endif
                        @if (Route::has('logout'))
                            <div role="separator" class="dropdown-divider my-1"></div>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center text-danger">Keluar</button>
                            </form>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>