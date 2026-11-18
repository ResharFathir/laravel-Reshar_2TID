@extends('layouts.app')
@section('title', 'Trending – Bumalo.id')

@section('content')
<div class="pad">
    <h1 class="page-title">Trending</h1>
    <p class="sub">Model yang paling banyak dicari minggu ini.</p>
    @include('partials.grid')
</div>
@endsection
