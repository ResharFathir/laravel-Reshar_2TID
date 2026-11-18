@extends('layouts.app')
@section('title', 'Hasil pencarian – Bumalo.id')

@section('content')
<div class="pad">
    <h1 class="page-title">Hasil: {{ $q }}</h1>
    <p class="sub">{{ $products->count() }} produk ditemukan.</p>
    @include('partials.grid')
</div>
@endsection
