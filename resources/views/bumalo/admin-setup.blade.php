@extends('bumalo.layout')
@section('title', 'Daftarkan admin pertama — Bumalo.id')
@section('content')
<section class="login-box"><div class="card"><span class="eyebrow">PENYIAPAN PERTAMA</span><h1 style="font:800 32px Manrope;letter-spacing:-1px">Daftarkan pemilik</h1><p class="muted">Halaman ini hanya aktif sebelum akun admin/pemilik pertama dibuat.</p>
<form method="post" action="{{ route('admin.setup.store') }}">@csrf
<label>Nama</label><input class="field" name="name" value="{{ old('name') }}" required autocomplete="name">
<label style="margin-top:14px">Email</label><input class="field" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
<label style="margin-top:14px">Nomor telepon (opsional)</label><input class="field" name="phone" autocomplete="tel">
<label style="margin-top:14px">Kata sandi (minimal 8 karakter)</label><input class="field" type="password" name="password" required autocomplete="new-password">
<label style="margin-top:14px">Ulangi kata sandi</label><input class="field" type="password" name="password_confirmation" required autocomplete="new-password">
<button class="pill dark" style="width:100%;margin-top:20px">Buat akun pemilik</button></form></div></section>
@endsection
