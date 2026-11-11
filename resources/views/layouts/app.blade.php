<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Reshar Fathir Zuhri</title>

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    {{-- Volt CSS --}}
    @include('layouts.css')
    {{-- End CSS --}}
    @stack('styles')

</head>

<body>
    {{-- Sidebar --}}
    @include('layouts.sidebar')
    {{-- End Sidebar --}}

    <main class="content">
        {{-- Start Header --}}
        @include('layouts.header')
        {{-- End Header --}}

        {{-- Start main content --}}
        @yield('content')
        {{-- End main content --}}

        {{-- Footer --}}
        @include('layouts.footer')
        {{-- End Footer --}}
    </main>

    {{-- Start JS --}}
    @include('layouts.js')
    {{-- End JS --}}
    @unless (file_exists(public_path('assets-admin/css/volt.css')))
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endunless
    @stack('scripts')
</body>

</html>