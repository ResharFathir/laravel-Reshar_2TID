@extends('layouts.admin')

@section('title', $portofolio->judul)

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portofolio.index') }}">Portofolio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <h1 class="h4">{{ $portofolio->judul }}</h1>
        <div>
            <a href="{{ route('portofolio.edit', $portofolio->id) }}" class="btn btn-outline-secondary me-2">Edit</a>
            <a href="{{ route('portofolio.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        @if ($portofolio->gambar)
            <img src="{{ asset('storage/' . $portofolio->gambar) }}" alt="Tampilan proyek {{ $portofolio->judul }}" class="img-fluid rounded mb-3" style="max-height:320px">
        @endif
        <p class="text-muted mb-2">{{ $portofolio->tanggal ? $portofolio->tanggal->translatedFormat('F Y') : 'Tanpa tanggal' }}</p>
        <p style="white-space:pre-line">{{ $portofolio->deskripsi }}</p>

        @if ($portofolio->teknologi)
            <div class="mb-3">
                @foreach (array_filter(array_map('trim', explode(',', $portofolio->teknologi))) as $tech)
                    <span class="badge bg-gray-200 text-gray-800">{{ $tech }}</span>
                @endforeach
            </div>
        @endif

        @if ($portofolio->link_demo)
            <a href="{{ $portofolio->link_demo }}" target="_blank" rel="noopener" class="me-3">Lihat demo</a>
        @endif
        @if ($portofolio->link_github)
            <a href="{{ $portofolio->link_github }}" target="_blank" rel="noopener">Kode di GitHub</a>
        @endif
    </div>
</div>
@endsection
