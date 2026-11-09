<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#080d1c">
    <title>Kelola Profil — Portofolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root { --page:#080d1c; --panel:#10182a; --line:rgba(167,190,255,.14); --text:#edf3ff; --muted:#9aa9c4; --accent:#80aaff; --mint:#85f2d1; }
        body { min-height:100vh; background:radial-gradient(ellipse at 90% 0,rgba(83,111,238,.16),transparent 34%),var(--page); color:var(--text); font-family:'DM Sans',sans-serif; }
        .page-wrap { width:min(920px,calc(100% - 28px)); margin:auto; }
        .topbar { border-bottom:1px solid var(--line); background:rgba(8,13,28,.8); backdrop-filter:blur(16px); }
        .brand { color:var(--text); font-family:'Space Grotesk',sans-serif; font-weight:700; text-decoration:none; }
        .brand span { color:var(--mint); }
        .panel { overflow:hidden; margin:34px 0 60px; border:1px solid var(--line); border-radius:25px; background:var(--panel); box-shadow:0 24px 70px rgba(0,0,0,.22); }
        .panel-head { padding:28px clamp(20px,5vw,42px); border-bottom:1px solid var(--line); background:linear-gradient(120deg,rgba(89,120,245,.13),rgba(89,230,198,.05)); }
        .panel-body { padding:clamp(20px,5vw,42px); }
        h1,h2 { font-family:'Space Grotesk',sans-serif; font-weight:700; letter-spacing:-.045em; }
        .eyebrow { color:var(--mint); font-size:.75rem; font-weight:700; letter-spacing:.13em; text-transform:uppercase; }
        .text-secondary,.form-text { color:var(--muted)!important; }
        .form-label { margin-bottom:7px; color:#dce6fa; font-size:.9rem; font-weight:600; }
        .form-control { min-height:46px; border:1px solid var(--line); border-radius:12px; background:#0b1222; color:var(--text); }
        textarea.form-control { min-height:unset; }
        .form-control:focus { border-color:rgba(128,170,255,.65); background:#0b1222; color:var(--text); box-shadow:0 0 0 3px rgba(128,170,255,.1); }
        .form-control::placeholder { color:#75829c; }
        .form-control[type=file] { padding:11px; }
        .form-control[type=file]::file-selector-button { margin:-5px 12px -5px -5px; padding:7px 11px; border:0; border-radius:8px; background:#1b2943; color:var(--text); }
        .photo-card { display:flex; align-items:center; gap:18px; padding:17px; border:1px solid var(--line); border-radius:17px; background:#0b1222; }
        .photo-frame { width:94px; height:94px; flex:0 0 auto; overflow:hidden; border:2px solid rgba(133,242,209,.48); border-radius:50%; background:#17233d; }
        .photo-frame img { width:100%; height:100%; object-fit:cover; }
        .photo-placeholder { display:grid; width:100%; height:100%; place-items:center; color:var(--mint); font-family:'Space Grotesk',sans-serif; font-size:1.6rem; font-weight:700; }
        .section-divider { margin:30px 0 22px; padding-bottom:12px; border-bottom:1px solid var(--line); color:var(--mint); font-family:'Space Grotesk',sans-serif; font-size:1.05rem; font-weight:700; }
        .btn-glow { border:0; border-radius:12px; background:linear-gradient(115deg,#5e7df4,#8d70ef); color:#fff; font-weight:700; }
        .btn-glow:hover { color:#fff; filter:brightness(1.08); }
        .btn-soft { border:1px solid var(--line); border-radius:12px; background:#17233d; color:var(--text); }
        .btn-soft:hover { border-color:var(--accent); color:#fff; }
        .btn-danger-soft { border:1px solid rgba(255,133,153,.3); border-radius:10px; background:rgba(255,89,122,.08); color:#ff9bac; }
        .btn-danger-soft:hover { border-color:#ff718b; color:#ff718b; }
        .alert { border-radius:12px; }
        @media(max-width:575px) { .photo-card { align-items:flex-start; flex-direction:column; } }
    </style>
</head>
<body>
<header class="topbar">
    <div class="page-wrap d-flex align-items-center justify-content-between py-3">
        <a class="brand" href="{{ route('portofolio.index') }}">omar<span>.portfolio</span></a>
        <a href="{{ route('portofolio.index') }}" class="btn btn-soft btn-sm px-3">← Kembali ke portofolio</a>
    </div>
</header>

<main class="page-wrap">
    <section class="panel">
        <div class="panel-head">
            <span class="eyebrow">Pusat identitas digital</span>
            <h1 class="h2 mt-2 mb-2">Kelola profil</h1>
            <p class="text-secondary mb-0">Perbarui foto, cerita, dan informasi yang tampil di halaman portofolio.</p>
        </div>
        <div class="panel-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa isian berikut:</strong>
                    <ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @if($profile->photo_path)
                <form action="{{ route('profile.photo.destroy') }}" method="POST" class="d-flex justify-content-end mb-3" onsubmit="return confirm('Hapus foto profil sekarang?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger-soft btn-sm px-3" type="submit">Hapus foto profil</button>
                </form>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="form-label">Nama lengkap</label>
                    <input id="name" name="name" class="form-control" value="{{ old('name', $profile->name) }}" maxlength="255" required>
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="photo" class="form-label">Foto profil</label>
                    <div class="photo-card">
                        <div class="photo-frame">
                            @if($profile->photo_path)
                                <img id="photoPreview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profile->photo_path) }}" alt="Foto profil saat ini">
                            @else
                                <div id="photoPlaceholder" class="photo-placeholder">ON</div>
                                <img id="photoPreview" src="" alt="Pratinjau foto baru" hidden>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $profile->photo_path ? 'Foto profil saat ini' : 'Belum ada foto profil' }}</div>
                            <p class="form-text mb-2">Pilih foto yang jelas. Format JPG, PNG, atau WEBP, maksimal 2 MB.</p>
                            <input id="photo" type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/webp">
                            @error('photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            <div id="photoFileName" class="form-text mt-2"></div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12"><label for="headline" class="form-label">Profesi / headline</label><input id="headline" name="headline" class="form-control" value="{{ old('headline', $profile->headline) }}" placeholder="Contoh: Mahasiswa · Web Developer"><div class="form-text">Satu kalimat singkat yang mengenalkan dirimu.</div></div>
                    <div class="col-12"><label for="summary" class="form-label">Tentang saya</label><textarea id="summary" name="summary" class="form-control" rows="4" maxlength="5000" placeholder="Ceritakan minat, fokus, atau tujuanmu…">{{ old('summary', $profile->summary) }}</textarea></div>
                </div>

                <h2 class="section-divider">Informasi kontak</h2>
                <div class="row g-3">
                    <div class="col-md-6"><label for="email" class="form-label">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email', $profile->email) }}" placeholder="nama@email.com">@error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="phone" class="form-label">Telepon</label><input id="phone" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" placeholder="+62 …"></div>
                    <div class="col-12"><label for="address" class="form-label">Lokasi</label><input id="address" name="address" class="form-control" value="{{ old('address', $profile->address) }}" placeholder="Kota, Indonesia"></div>
                    <div class="col-md-6"><label for="linkedin" class="form-label">LinkedIn</label><input id="linkedin" type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="https://linkedin.com/in/…">@error('linkedin')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="github" class="form-label">GitHub / situs</label><input id="github" type="url" name="github" class="form-control" value="{{ old('github', $profile->github) }}" placeholder="https://github.com/…">@error('github')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                </div>

                <h2 class="section-divider">Keahlian & pendidikan</h2>
                <div class="row g-3">
                    <div class="col-md-6"><label for="skills" class="form-label">Keahlian</label><textarea id="skills" name="skills" class="form-control" rows="5" maxlength="5000" placeholder="Satu keahlian per baris">{{ old('skills', $profile->skills) }}</textarea><div class="form-text">Satu keahlian per baris.</div></div>
                    <div class="col-md-6"><label for="education" class="form-label">Pendidikan</label><textarea id="education" name="education" class="form-control" rows="5" maxlength="5000" placeholder="2022–2025 | Nama institusi | Program studi">{{ old('education', $profile->education) }}</textarea><div class="form-text">Satu jenjang atau program per baris.</div></div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4 pt-3">
                    <button type="submit" class="btn btn-glow px-4 py-2">Simpan perubahan</button>
                    <a href="{{ route('portofolio.index') }}" class="btn btn-soft px-4 py-2">Batal</a>
                </div>
            </form>
        </div>
    </section>
</main>
<script>
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');
    const photoFileName = document.getElementById('photoFileName');
    let previewUrl;

    photoInput.addEventListener('change', () => {
        const [file] = photoInput.files;
        if (!file) return;
        if (previewUrl) URL.revokeObjectURL(previewUrl);
        previewUrl = URL.createObjectURL(file);
        photoPreview.src = previewUrl;
        photoPreview.hidden = false;
        if (photoPlaceholder) photoPlaceholder.hidden = true;
        photoFileName.textContent = `Foto baru: ${file.name}`;
    });
</script>
</body>
</html>