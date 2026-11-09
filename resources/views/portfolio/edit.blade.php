@extends('portfolio.layout')

@section('title', 'Edit proyek')

@section('content')
    <div class="flow-heading">
        <span class="flow-eyebrow">Atur koleksi karya</span>
        <h1 class="flow-title">Perbarui proyek.</h1>
        <p class="flow-copy mb-0">Sunting informasi, ganti gambar, atau perbarui link demo proyekmu.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">Periksa kembali data proyek yang dimasukkan.</div>
    @endif

    <form class="flow-card" action="{{ route('portofolio.update', $portofolio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="judul" class="form-label flow-label">Nama proyek</label>
            <input id="judul" type="text" name="judul" class="form-control flow-control" value="{{ old('judul', $portofolio->judul) }}" maxlength="255" required>
            @error('judul')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="form-label flow-label">Cerita proyek</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control flow-control" rows="5" required>{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
            @error('deskripsi')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="teknologi" class="form-label flow-label">Teknologi</label>
                <input id="teknologi" type="text" name="teknologi" class="form-control flow-control" value="{{ old('teknologi', $portofolio->teknologi) }}" required>
                <div class="flow-hint">Pisahkan beberapa teknologi dengan koma.</div>
                @error('teknologi')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="link" class="form-label flow-label">Link demo <span class="text-secondary fw-normal">(opsional)</span></label>
                <input id="link" type="url" name="link" class="form-control flow-control" value="{{ old('link', $portofolio->link) }}" placeholder="https://contoh.com/proyek" maxlength="2048">
                <div class="flow-hint">Kosongkan untuk menghapus link demo dari proyek.</div>
                @error('link')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <h2 class="flow-divider">Visual proyek</h2>
        @if($portofolio->gambar)
            <div class="mb-3">
                <p class="flow-label">Sampul saat ini</p>
                <img id="imagePreview" class="flow-preview d-block mb-3" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($portofolio->gambar) }}" alt="Sampul {{ $portofolio->judul }}">
                <div class="form-check">
                    <input id="hapus_gambar" type="checkbox" name="hapus_gambar" value="1" class="form-check-input">
                    <label for="hapus_gambar" class="form-check-label text-secondary">Hapus sampul tanpa menghapus proyek</label>
                </div>
            </div>
        @else
            <img id="imagePreview" class="flow-preview mb-3" alt="Pratinjau sampul proyek" hidden>
        @endif
        <div class="mb-4">
            <label for="gambar" class="form-label flow-label">Ganti / tambah sampul <span class="text-secondary fw-normal">(opsional)</span></label>
            <input id="gambar" type="file" name="gambar" class="form-control flow-control" accept="image/jpeg,image/png,image/webp">
            <div class="flow-hint">JPG, PNG, atau WEBP. Maksimal 2 MB. Kosongkan untuk mempertahankan sampul saat ini.</div>
            @error('gambar')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex flex-wrap gap-2 pt-2">
            <button type="submit" class="btn flow-button px-4 py-2">Simpan perubahan</button>
            <a href="{{ route('portofolio.show', $portofolio) }}" class="btn flow-secondary px-4 py-2">Lihat detail</a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const imageInput = document.getElementById('gambar');
        const imagePreview = document.getElementById('imagePreview');
        let previewUrl;

        imageInput.addEventListener('change', () => {
            const [file] = imageInput.files;
            if (!file) return;
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = URL.createObjectURL(file);
            imagePreview.src = previewUrl;
            imagePreview.hidden = false;
        });
    </script>
@endpush