@extends('layouts.admin')
@section('title', 'Tambah produk')

@section('content')
<h1>Tambah produk</h1>
<form method="POST" action="{{ route('admin.products.store') }}">
    @include('admin.products._form')
</form>
@endsection
