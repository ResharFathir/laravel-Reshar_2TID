@extends('layouts.admin')

@section('title', 'Portofolio')

@push('styles')
<style>
    .cv-sheet { max-width: 920px; margin: 0 auto; }
    .cv-header { border-bottom: 3px solid #262b40; padding-bottom: 1.25rem; margin-bottom: 1.5rem; }
    .cv-name { font-size: 2rem; font-weight: 700; letter-spacing: -.01em; margin-bottom: .15rem; }
    .cv-role { font-size: 1.05rem; color: #4a5073; margin-bottom: .75rem; }
    .cv-contact span { display: inline-block; margin-right: 1.25rem; font-size: .9rem; color: #4a5073; }
    .cv-section-title { font-size: 1.1rem; font-weight: 700; border-bottom: 1px solid #d1d7e0; padding-bottom: .4rem; margin: 1.75rem 0 1.25rem; }

    .cv-item { display: flex; gap: 1.25rem; padding-bottom: 1.5rem; margin-bottom: 1.5rem; border-bottom: 1px dashed #d1d7e0; }
    .cv-item:last-child { border-bottom: 0; margin-bottom: 0; padding-bottom: 0; }
    .cv-date { flex: 0 0 120px; font-size: .85rem; font-weight: 600; color: #4a5073; padding-top: .2rem; }
    .cv-body { flex: 1; min-width: 0; }
    .cv-title { font-size: 1.05rem; font-weight: 700; margin-bottom: .35rem; }
    .cv-desc { margin-bottom: .75rem; white-space: pre-line; max-width: 70ch; }
    .cv-thumb { width: 100%; max-width: 320px; border-radius: .5rem; border: 1px solid #e5e7eb; margin-bottom: .75rem; display: block; }
    .cv-tech .badge { margin: 0 .25rem .25rem 0; font-weight: 500; }
    .cv-links a { margin-right: 1rem; font-size: .9rem; }
    .cv-admin { margin-top: .75rem; display: flex; gap: .5rem; }

    @media (max-width: 575.98px) {
        .cv-item { flex-direction: column; gap: .25rem; }
        .cv-date { flex-basis: auto; }
    }

    /* Saat dicetak: hanya lembar CV yang tampil */
    @media print {
        .sidebar, .navbar, footer, .no-print, .cv-admin { display: none !important; }
        main.content { padding: 0 !important; margin: 0 !important; }
        .card { box-shadow: none !important; border: 0 !important; }
        .cv-item { break-inside: avoid; }
    }
</style>
@endpush

@section('content')
@php
    // Ubah teks ini sesuai identitasmu
    $cv = [
        'nama'    => 'Nama Lengkap Kamu',
        'jabatan' => 'Web Developer',
        'email'   => 'email@contoh.com',
        'telepon' => '0812-0000-0000',
        'lokasi'  => 'Pekanbaru, Riau',
        'ringkasan' => 'Ringkasan singkat tentang dirimu: keahlian utama, pengalaman, dan jenis proyek yang kamu sukai.',
    ];

    $items = $portofolio instanceof \Illuminate\Pagination\AbstractPaginator ? $portofolio->items() : $portofolio;
@endphp

<div class="py-4 no-print">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Portofolio</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">CV Portofolio</h1>
            <p class="mb-0">Kelola proyek yang tampil di CV kamu.</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-gray-600 me-2" onclick="window.print()">Cetak CV</button>
            <a href="{{ route('portofolio.create') }}" class="btn btn-primary">Tambah proyek</a>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success no-print" role="alert">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="cv-sheet">

                    {{-- Kepala CV --}}
                    <header class="cv-header">
                        <h2 class="cv-name">{{ $cv['nama'] }}</h2>
                        <div class="cv-role">{{ $cv['jabatan'] }}</div>
                        <div class="cv-contact">
                            <span>{{ $cv['email'] }}</span>
                            <span>{{ $cv['telepon'] }}</span>
                            <span>{{ $cv['lokasi'] }}</span>
                        </div>
                    </header>

                    <section>
                        <h3 class="cv-section-title">Ringkasan</h3>
                        <p class="mb-0" style="max-width:70ch">{{ $cv['ringkasan'] }}</p>
                    </section>

                    {{-- Daftar proyek --}}
                    <section>
                        <h3 class="cv-section-title">Proyek</h3>

                        @forelse ($items as $item)
                            <article class="cv-item">
                                <div class="cv-date">
                                    {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('F Y') : 'Tanpa tanggal' }}
                                </div>

                                <div class="cv-body">
                                    <h4 class="cv-title">{{ $item->judul }}</h4>

                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Tampilan proyek {{ $item->judul }}" class="cv-thumb">
                                    @endif

                                    <p class="cv-desc">{{ $item->deskripsi }}</p>

                                    @if ($item->teknologi)
                                        <div class="cv-tech">
                                            @foreach (array_filter(array_map('trim', explode(',', $item->teknologi))) as $tech)
                                                <span class="badge bg-gray-200 text-gray-800">{{ $tech }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($item->link_demo || $item->link_github)
                                        <div class="cv-links mt-2">
                                            @if ($item->link_demo)
                                                <a href="{{ $item->link_demo }}" target="_blank" rel="noopener">Lihat demo</a>
                                            @endif
                                            @if ($item->link_github)
                                                <a href="{{ $item->link_github }}" target="_blank" rel="noopener">Kode di GitHub</a>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Aksi admin (tidak ikut tercetak) --}}
                                    <div class="cv-admin no-print">
                                        <a href="{{ route('portofolio.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <form action="{{ route('portofolio.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus proyek &quot;{{ addslashes($item->judul) }}&quot;? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="text-center py-5">
                                <p class="mb-3">Belum ada proyek di CV kamu.</p>
                                <a href="{{ route('portofolio.create') }}" class="btn btn-primary no-print">Tambah proyek pertama</a>
                            </div>
                        @endforelse
                    </section>

                </div>
            </div>
        </div>

        @if ($portofolio instanceof \Illuminate\Pagination\AbstractPaginator)
            <div class="mt-3 no-print">{{ $portofolio->links() }}</div>
        @endif
    </div>
</div>
@endsection