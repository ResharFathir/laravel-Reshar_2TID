@extends('bumalo.layout')
@section('title', 'Bumalo.id — Sepatu pilihan')
@section('content')
<section class="hero" style="margin-top:34px">
    <div><span class="eyebrow">LANGKAH BARU DIMULAI DI SINI</span><h1 style="font:800 clamp(42px,7vw,76px) Manrope;letter-spacing:-4px;line-height:1.04;margin:20px 0">Temukan sepatu untuk setiap langkah.</h1><p class="muted" style="font-size:17px;line-height:1.8">Koleksi sepatu olahraga pilihan untuk berlari, bermain, dan bergerak setiap hari.</p><a class="pill dark" href="#koleksi">Jelajahi koleksi ↓</a></div>
    <div class="hero-img product-art" style="display:grid;place-items:center;font-size:120px">👟</div>
</section>
<section id="koleksi" class="section" style="margin-top:42px">
    <div class="row"><div><span class="eyebrow">KOLEKSI BUMALO</span><h2 style="font:800 32px Manrope;margin:10px 0 20px">Sepatu pilihan</h2></div><span class="muted">{{ $products->count() }} produk</span></div>
    <form method="get" action="{{ route('shop.index') }}" class="filters" style="margin-bottom:20px">
        <input class="field" name="q" value="{{ request('q') }}" placeholder="Cari sepatu...">
        <select class="field" name="kategori"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->name }}" @selected(request('kategori')===$category->name)>{{ $category->name }}</option>@endforeach</select>
        <select class="field" name="brand"><option value="">Semua merek</option>@foreach($brands as $brand)<option value="{{ $brand->id }}" @selected((string)request('brand')===(string)$brand->id)>{{ $brand->name }}</option>@endforeach</select>
        <button class="pill dark">Cari</button>
    </form>
    @if($products->isEmpty())<div class="card"><h3>Produk belum tersedia</h3><p class="muted">Coba ubah kata kunci atau pilihan kategori.</p></div>@else
    <div class="grid">@foreach($products as $product)<a class="card" href="{{ route('shop.product', $product->slug) }}" style="text-decoration:none;color:inherit;padding:0;overflow:hidden"><div class="product-art" style="height:220px;display:grid;place-items:center;font-size:76px">@if($product->image)<img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover">@else👟@endif</div><div style="padding:17px"><span class="eyebrow">{{ $product->brand->name }} · {{ $product->category->name }}</span><h3 style="margin:8px 0">{{ $product->name }}</h3><p class="muted small">{{ Str::limit($product->description, 75) }}</p><strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong><p class="small muted" style="margin-bottom:0">{{ $product->variants->sum('stock') }} pasang tersedia</p></div></a>@endforeach</div>
    @endif
</section>
@endsection
