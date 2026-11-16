@extends('layouts.admin')
@section('title', 'Ubah produk')

@section('content')
<h1>Ubah produk</h1>
<form method="POST" action="{{ route('admin.products.update', $product) }}">
    @method('PUT')
    @include('admin.products._form')
</form>
@endsection
