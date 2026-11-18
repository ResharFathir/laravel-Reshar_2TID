@extends('bumalo.layouts.app')
@section('title', $title . ' – Bumalo.id')

@section('content')
<div class="pad">
    <h1 class="page-title">{{ $title }}</h1>
    <p class="sub">Pilih merek untuk menyaring daftar.</p>
    <div class="tabs">
        <a class="chip {{ !$brand ? 'on' : '' }}" href="{{ route('toko.kategori', $gender) }}">Semua</a>
        @foreach ($brands as $b)
            <a class="chip {{ $brand === $b ? 'on' : '' }}" href="{{ route('toko.kategori', $gender) }}?brand={{ $b }}">{{ $b }}</a>
        @endforeach
    </div>
    @include('bumalo.partials.grid')
</div>
@endsection
