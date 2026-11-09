@extends('portfolio.layout')

@section('title', 'Tambah proyek')

@section('content')
    <div class="flow-heading">
        <span class="flow-eyebrow">Koleksi karya · 01</span>
        <h1 class="flow-title">Tambahkan proyek baru.</h1>
        <p class="flow-copy mb-0">Ceritakan proses dan hasil karyamu. Tambahkan URL demo agar pengunjung dapat mencobanya langsung.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">Periksa kembali data proyek yang dimasukkan.</div>
    @endif

    <form class="flow-card" action="{{ route('portofolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="judul" class="form-label flow-label">Nama proyek</label>
            <input id="judul" type="text" name="judul" class="form-control flow-control" value="{{ old('judul') }}" maxlength="255" placeholder="Contoh: Dashboard analitik pintar" required>
            @error('judul')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="form-label flow-label">Cerita proyek</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control flow-control" rows="5" placeholder="Apa yang dibangun, masalah yang diselesaikan, dan hal yang kamu pelajari…" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="teknologi" class="form-label flow-label">Teknologi</label>
                <input id="teknologi" type="text" name="teknologi" class="form-control flow-control" value="{{ old('teknologi') }}" placeholder="Laravel, MySQL, Bootstrap" required>
                <div class="flow-hint">Pisahkan beberapa teknologi dengan koma.</div>
                @error('teknologi')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="link" class="form-label flow-label">Link demo <span class="text-secondary fw-normal">(opsional)</span></label>
                <input id="link" type="url" name="link" class="form-control flow-control" value="{{ old('link') }}" placeholder="https://contoh.com/proyek" maxlength="2048">
                <div class="flow-hint">Link publik ke demo langsung, repositori, atau hasil karya.</div>
                @error('link')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <h2 class="flow-divider">Visual proyek</h2>
        <div class="mb-4">
            <label for="gambar" class="form-label flow-label">Gambar sampul <span class="text-secondary fw-normal">(opsional)</span></label>
            <input id="gambar" type="file" name="gambar" class="form-control flow-control" accept="image/jpeg,image/png,image/webp">
            <div class="flow-hint">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
            @error('gambar')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            <img id="imagePreview" class="flow-preview mt-3" alt="Pratinjau sampul proyek" hidden>
        </div>

        <div class="d-flex flex-wrap gap-2 pt-2">
            <button type="submit" class="btn flow-button px-4 py-2">Simpan proyek</button>
            <a href="{{ route('portofolio.index') }}" class="btn flow-secondary px-4 py-2">Batal</a>
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