@extends('bumalo.layout')
@section('title', 'Daftar akun — Bumalo.id')
@section('content')
<section class="login-box"><div class="card"><span class="eyebrow">AKUN PELANGGAN</span><h1 style="font:800 32px Manrope;letter-spacing:-1px">Buat akun Bumalo</h1><p class="muted">Daftar untuk masuk dan lanjut belanja. Checkout tetap bisa memakai detail penerima.</p>
<form method="post" action="{{ route('register.store') }}">@csrf
<label>Nama lengkap</label><input class="field" name="name" value="{{ old('name') }}" required autocomplete="name">
<label style="margin-top:14px">Email</label><input class="field" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
<label style="margin-top:14px">Nomor telepon (opsional)</label><input class="field" name="phone" value="{{ old('phone') }}" autocomplete="tel">
<label style="margin-top:14px">Kata sandi (minimal 8 karakter)</label><input class="field" type="password" name="password" required autocomplete="new-password">
<label style="margin-top:14px">Ulangi kata sandi</label><input class="field" type="password" name="password_confirmation" required autocomplete="new-password">
<button class="pill dark" style="width:100%;margin-top:20px">Daftar</button></form>
<p class="small muted" style="margin:18px 0 0">Sudah punya akun? <a href="{{ route('login') }}"><b>Masuk</b></a></p></div></section>
@endsection
