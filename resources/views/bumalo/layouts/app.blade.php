<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Bumalo.id – Toko Sepatu')</title>
    @include('bumalo.layouts.css')
</head>
<body>
    @include('bumalo.layouts.header')
    <main id="app">
        @yield('content')
    </main>
    @include('bumalo.layouts.footer')
    <div id="toast" role="status"></div>
    @include('bumalo.layouts.js')
</body>
</html>
