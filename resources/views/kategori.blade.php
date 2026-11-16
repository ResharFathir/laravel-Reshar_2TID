@extends('layouts.app')
@section('title', $title . ' – Bumalo.id')

@section('content')
<div class="pad">
    <h1 class="page-title">{{ $title }}</h1>
    <p class="sub">Pilih merek untuk menyaring daftar.</p>
    <div class="tabs">
        <a class="chip {{ !$brand ? 'on' : '' }}" href="{{ route('kategori', $gender) }}">Semua</a>
        @foreach ($brands as $b)
            <a class="chip {{ $brand === $b ? 'on' : '' }}" href="{{ route('kategori', $gender) }}?brand={{ $b }}">{{ $b }}</a>
        @endforeach
    </div>
    @include('partials.grid')
</div>
@endsection
