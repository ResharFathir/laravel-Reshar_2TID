@extends('bumalo.layout')
@section('title', ($editing ? 'Ubah akun' : 'Tambah akun').' — Bumalo.id')
@section('content')
<section class="login-box" style="max-width:650px"><div class="card"><a class="small muted" href="{{ route('admin.accounts.index') }}">← Kembali ke daftar akun</a><h1 style="font:800 32px Manrope;letter-spacing:-1px">{{ $editing ? 'Ubah akun' : 'Tambah akun' }}</h1>
<form method="post" action="{{ $editing ? route('admin.accounts.update', $account) : route('admin.accounts.store') }}">@csrf @if($editing) @method('PUT') @endif
<label>Nama</label><input class="field" name="name" value="{{ old('name', $account->name) }}" required>
<label style="margin-top:14px">Email</label><input class="field" type="email" name="email" value="{{ old('email', $account->email) }}" required>
<label style="margin-top:14px">Nomor telepon</label><input class="field" name="phone" value="{{ old('phone', $account->phone) }}">
<label style="margin-top:14px">Peran</label><select class="field" name="role" required>@foreach(['customer'=>'Pelanggan','admin'=>'Admin','owner'=>'Pemilik','warehouse'=>'Gudang'] as $value=>$label)<option value="{{ $value }}" @selected(old('role', $account->role ?: 'customer')===$value)>{{ $label }}</option>@endforeach</select>
<label style="margin-top:14px">{{ $editing ? 'Kata sandi baru (kosongkan jika tidak diganti)' : 'Kata sandi (minimal 8 karakter)' }}</label><input class="field" type="password" name="password" @required(!$editing) autocomplete="new-password">
<label style="margin-top:14px">Ulangi kata sandi</label><input class="field" type="password" name="password_confirmation" @required(!$editing) autocomplete="new-password">
<button class="pill dark" style="width:100%;margin-top:20px">{{ $editing ? 'Simpan perubahan' : 'Buat akun' }}</button></form></div></section>
@endsection
