@extends('portfolio.layout')

@section('title', $portofolio->judul)

@section('content')
    <div class="flow-heading d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <span class="flow-eyebrow">Studi karya · Portofolio</span>
            <h1 class="flow-title mb-2">{{ $portofolio->judul }}</h1>
            <p class="flow-copy mb-0">Dibagikan {{ $portofolio->created_at?->translatedFormat('d F Y') ?: 'sebagai bagian dari portofolio' }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('portofolio.edit', $portofolio) }}" class="btn flow-secondary px-3 py-2">Edit proyek</a>
            <a href="{{ route('portofolio.index') }}" class="btn flow-secondary px-3 py-2">← Semua karya</a>
        </div>
    </div>

    <article class="flow-card">
        @if($portofolio->gambar)
            <img class="flow-preview w-100 mb-4" style="max-height:460px" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($portofolio->gambar) }}" alt="Sampul {{ $portofolio->judul }}">
        @else
            <div class="d-grid place-items-center mb-4 p-5 text-center" style="min-height:220px;border:1px dashed var(--line);border-radius:16px;background:radial-gradient(circle at 70% 30%,rgba(105,134,255,.2),transparent 32%),#0b1222">
                <span style="font-size:2.5rem;color:var(--mint)">✳</span>
                <span class="flow-hint">Belum ada gambar sampul untuk karya ini.</span>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <h2 class="h4 mb-3" style="font-family:'Space Grotesk',sans-serif">Tentang proyek</h2>
                <p class="mb-0" style="color:var(--muted);line-height:1.85;white-space:pre-line">{{ $portofolio->deskripsi }}</p>
            </div>
            <aside class="col-lg-4">
                <h2 class="h6 mb-3" style="font-family:'Space Grotesk',sans-serif">Dibangun dengan</h2>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(collect(explode(',', $portofolio->teknologi))->map(fn ($technology) => trim($technology))->filter() as $technology)
                        <span class="badge rounded-pill px-3 py-2" style="border:1px solid var(--line);background:var(--panel-soft);color:#a7c2ff">{{ $technology }}</span>
                    @endforeach
                </div>
                @if($portofolio->link)
                    <a href="{{ $portofolio->link }}" class="btn flow-button w-100 mt-4 px-3 py-3" target="_blank" rel="noopener noreferrer">Buka karya langsung <span aria-hidden="true">↗</span></a>
                    <p class="flow-hint">Link terbuka di tab baru.</p>
                @else
                    <div class="flow-hint mt-4">Belum ada link demo untuk proyek ini.</div>
                @endif
            </aside>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-4 pt-4" style="border-top:1px solid var(--line)">
            <a href="{{ route('portofolio.index') }}" class="flow-link text-decoration-none">← Kembali ke galeri</a>
            <form action="{{ route('portofolio.destroy', $portofolio) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn flow-danger btn-sm px-3">Hapus proyek</button>
            </form>
        </div>
    </article>
@endsection