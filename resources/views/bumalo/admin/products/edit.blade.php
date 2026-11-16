@extends('bumalo.layouts.admin')
@section('title', 'Ubah produk')

@section('content')
<h1>Ubah produk</h1>
<form method="POST" action="{{ route('toko.admin.products.update', $product) }}">
    @method('PUT')
    @include('bumalo.admin.products._form')
</form>
@endsection
