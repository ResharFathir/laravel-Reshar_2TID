@extends('layouts.admin')

@section('title', 'Edit Portofolio')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portofolio.index') }}">Portofolio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Portofolio</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Portofolio</h1>
            <p class="mb-0">Ubah data proyek "{{ $portofolio->judul }}".</p>
        </div>
        <div>
            <a href="{{ route('portofolio.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Perubahan belum bisa disimpan:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">
                <form action="{{ route('portofolio.update', $portofolio->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul proyek</label>
                                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $portofolio->judul) }}" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="teknologi" class="form-label">Teknologi</label>
                                <input type="text" id="teknologi" name="teknologi" class="form-control @error('teknologi') is-invalid @enderror" value="{{ old('teknologi', $portofolio->teknologi) }}" placeholder="Laravel, MySQL, Bootstrap">
                                <div class="form-text">Pisahkan dengan koma.</div>
                                @error('teknologi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal selesai</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', optional($portofolio->tanggal)->format('Y-m-d') ?? $portofolio->tanggal) }}">
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                @if ($portofolio->gambar)
                                    <div class="mb-2">
                                        <img id="gambar-lama" src="{{ asset('storage/' . $portofolio->gambar) }}" alt="Gambar {{ $portofolio->judul }}" class="img-fluid rounded" style="max-height:180px">
                                        <div class="form-text">Gambar saat ini. Pilih file baru untuk menggantinya.</div>
                                    </div>
                                @endif
                                <input type="file" id="gambar" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <img id="preview" src="" alt="Pratinjau gambar baru" class="img-fluid rounded mt-2 d-none" style="max-height:180px">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="link_demo" class="form-label">Link demo</label>
                                <input type="url" id="link_demo" name="link_demo" class="form-control @error('link_demo') is-invalid @enderror" value="{{ old('link_demo', $portofolio->link_demo) }}" placeholder="https://">
                                @error('link_demo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="link_github" class="form-label">Link GitHub</label>
                                <input type="url" id="link_github" name="link_github" class="form-control @error('link_github') is-invalid @enderror" value="{{ old('link_github', $portofolio->link_github) }}" placeholder="https://github.com/">
                                @error('link_github') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                            <a href="{{ route('portofolio.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Pratinjau gambar baru sebelum diupload
    document.getElementById('gambar').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const img = document.getElementById('preview');
        if (file) {
            img.src = URL.createObjectURL(file);
            img.classList.remove('d-none');
        } else {
            img.classList.add('d-none');
        }
    });
</script>
@endpush