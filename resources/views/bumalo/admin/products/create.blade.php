@extends('bumalo.layouts.admin')
@section('title', 'Tambah produk')

@section('content')
<h1>Tambah produk</h1>
<form method="POST" action="{{ route('toko.admin.products.store') }}">
    @include('bumalo.admin.products._form')
</form>
@endsection
