<!--

=========================================================
- Volt Pro - Premium Bootstrap 5 Dashboard
=========================================================

- Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
- Copyright 2021 Themesberg (https://www.themesberg.com)
- License (https://themesberg.com/licensing)

- Designed and coded by https://themesberg.com

=========================================================

- The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Volt - Free Bootstrap 5 Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Volt - Free Bootstrap 5 Dashboard">
    <meta name="author" content="Themesberg">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets-admin/img/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets-admin/img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets-admin/img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets-admin/img/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('assets-admin/img/favicon/safari-pinned-tab.svg')}}" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Start -->
    <!-- Volt CSS -->
      @include('layouts.admin.css')
</head>

<body>
    <!-- start sidebar -->
       @include('layouts.admin.sidebar')
      <!-- end sidebar -->
    <main class="content">
         <!-- start header -->
        @include('layouts.admin.header')
        <!-- end header -->
         <!-- start main content -->
        @yield('content')

        <!-- end main content -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow components-section">
                    <div class="card-body">
                        <form action="{{ route('pelanggan.store') }}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-lg-4 col-sm-6">
                                    <!-- First Name -->
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6">
                                    <!-- Birthday -->
                                    <div class="mb-3">
                                        <label for="birthday" class="form-label">Birthday</label>
                                        <input type="date" id="birthday" name="birthday" class="form-control">
                                    </div>

                                    <!-- Gender -->
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select id="gender" name="gender" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>

                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" id="phone" name="phone" class="form-control">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
         <!-- start footer -->
        @include('layouts.admin.footer')
        <!-- end footer -->
	</main>
     <!-- start JS -->
	<!-- Core -->
	@include('layouts.admin.js')
    <!-- end JS -->
</body>

</html>