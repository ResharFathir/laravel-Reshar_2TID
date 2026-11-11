@extends('bumalo.admin-layout')
@section('title', ($editing ? 'Ubah akun' : 'Tambah akun').' - Bumalo AI Console')
@section('content')
<section class="section">
    <div class="admin-form-page-heading"><a class="admin-back-link" href="{{ route('admin.accounts.index') }}">&larr; Kembali ke daftar akun</a><span class="ai-kicker ai-kicker-dark">IDENTITY MANAGEMENT</span><h1>{{ $editing ? 'Ubah akun' : 'Tambah akun' }}</h1><p>Kelola identitas dan hak akses pengguna toko dengan aman.</p></div>
    <div class="card account-form">
        <div class="form-card-heading"><span class="form-card-icon">&#9672;</span><div><strong>Informasi akun</strong><small>Lengkapi data berikut untuk {{ $editing ? 'memperbarui akun' : 'membuat akses baru' }}.</small></div></div>
        <form method="post" action="{{ $editing ? route('admin.accounts.update', $account) : route('admin.accounts.store') }}">
            @csrf @if($editing) @method('PUT') @endif
            <div class="admin-form-grid">
                <div><label for="account-name">Nama</label><input class="field" id="account-name" name="name" value="{{ old('name', $account->name) }}" required autocomplete="name"></div>
                <div><label for="account-email">Email</label><input class="field" id="account-email" type="email" name="email" value="{{ old('email', $account->email) }}" required autocomplete="email"></div>
                <div><label for="account-phone">Nomor telepon</label><input class="field" id="account-phone" name="phone" value="{{ old('phone', $account->phone) }}" autocomplete="tel"></div>
                <div><label for="account-role">Peran akses</label><select class="field" id="account-role" name="role" required>@foreach(['customer'=>'Pelanggan','admin'=>'Admin','owner'=>'Pemilik','warehouse'=>'Gudang'] as $value=>$label)<option value="{{ $value }}" @selected(old('role', $account->role ?: 'customer')===$value)>{{ $label }}</option>@endforeach</select></div>
                <div><label for="account-password">{{ $editing ? 'Kata sandi baru (opsional)' : 'Kata sandi (minimal 8 karakter)' }}</label><input class="field" id="account-password" type="password" name="password" @required(!$editing) autocomplete="new-password"><small class="field-hint">{{ $editing ? 'Kosongkan bila tidak ingin mengganti kata sandi.' : 'Gunakan minimal 8 karakter.' }}</small></div>
                <div><label for="account-password-confirmation">Ulangi kata sandi</label><input class="field" id="account-password-confirmation" type="password" name="password_confirmation" @required(!$editing) autocomplete="new-password"></div>
            </div>
            <div class="form-actions"><button class="pill dark">{{ $editing ? 'Simpan perubahan' : 'Buat akun' }}</button><a class="pill line" href="{{ route('admin.accounts.index') }}">Batal</a></div>
        </form>
    </div>
</section>
@endsection
