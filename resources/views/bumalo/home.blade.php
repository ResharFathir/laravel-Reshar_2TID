@extends('bumalo.layout')
@section('content')
<section class="hero">
    <div class="hero-copy">
        <span class="hero-brand">BUMALO <span>PERFORMANCE & SPORT</span></span>
        <span class="eyebrow">MOVE WITH PURPOSE · KOLEKSI PILIHAN</span>
        <h1>Temukan<br>ritme<br><em>gerakmu.</em></h1>
        <p>Perlengkapan olahraga untuk setiap langkah, latihan, dan permainan. Pilih gear yang siap menemani kamu melaju lebih jauh.</p>
        <a class="pill dark" href="#koleksi">Jelajahi koleksi <span aria-hidden="true">→</span></a>
        <div class="hero-bottom-note">DIBUAT UNTUK BERGERAK <span>·</span> SIAP UNTUK LANGKAH BERIKUTNYA</div>
    </div>
    <div class="hero-img" role="img" aria-label="Atlet berlari di luar ruangan"></div>
    <div class="hero-side-label">BUMALO / ACTIVE LIFE</div>
</section>
<section class="section" id="koleksi">
    <div class="section-head">
        <div><span class="eyebrow">SHOP THE COLLECTION</span><h2>Gear untuk gerakmu</h2><p class="sub">Temukan sepatu yang cocok untuk arena dan rutinitasmu.</p></div>
        <span class="result-count"><strong>{{ $products->count() }}</strong> produk ditemukan</span>
    </div>
    <form class="catalog-toolbar" method="get" action="{{ route('shop.index') }}">
        <label class="catalog-search"><span aria-hidden="true">⌕</span><input name="q" value="{{ request('q') }}" placeholder="Cari produk atau aktivitas..." aria-label="Cari produk"></label>
        <select class="catalog-select" name="kategori" aria-label="Filter kategori"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->name }}" @selected(request('kategori')===$category->name)>{{ $category->name }}</option>@endforeach</select>
        <select class="catalog-select" name="brand" aria-label="Filter merek"><option value="">Semua merek</option>@foreach($brands as $brand)<option value="{{ $brand->id }}" @selected((string)request('brand')===(string)$brand->id)>{{ $brand->name }}</option>@endforeach</select>
        <select class="catalog-select" name="price" aria-label="Urutkan produk"><option value="">Terbaru</option><option value="low" @selected(request('price')==='low')>Harga terendah</option><option value="high" @selected(request('price')==='high')>Harga tertinggi</option><option value="name" @selected(request('price')==='name')>Nama A–Z</option></select>
        <label class="stock-filter"><input type="checkbox" name="ready_stock" value="1" @checked(request()->boolean('ready_stock'))> Stok tersedia</label>
        <button class="pill dark catalog-submit">Terapkan</button>
        @if(request()->hasAny(['q','kategori','brand','price','ready_stock']))<a class="catalog-reset" href="{{ route('shop.index') }}">Hapus filter</a>@endif
    </form>
    <div class="active-filter-row">
        <span class="muted">Pilih aktivitas:</span>
        <a class="filter-chip {{ request('kategori') ? '' : 'selected' }}" href="{{ route('shop.index', request()->except('kategori')) }}">Semua</a>
        @foreach($categories as $category)<a class="filter-chip {{ request('kategori')===$category->name ? 'selected' : '' }}" href="{{ route('shop.index', array_merge(request()->except('kategori'), ['kategori'=>$category->name])) }}">{{ $category->name }}</a>@endforeach
    </div>
    <div class="grid">@forelse($products as $product)<article class="product-card"><a href="{{ route('shop.product', $product->slug) }}"><div class="product-art"><span class="stock-tag">{{ $product->variants->sum('stock') ? 'UKURAN TERSEDIA' : 'STOK HABIS' }}</span>@if($product->image)<img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:14px">@else<span class="shoe">&#128095;</span>@endif</div><div class="product-meta"><small>{{ strtoupper($product->category->name) }} · {{ $product->brand->name }}</small><h3>{{ $product->name }}</h3><p>{{ Str::limit($product->description, 66) }}</p><div class="product-bottom"><span class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</span><span class="muted">Lihat detail →</span></div></div></a></article>@empty<div class="empty-products"><span>⌕</span><h3>Belum ada produk yang cocok</h3><p>Coba ubah kata kunci atau hapus beberapa filter.</p><a class="pill dark" href="{{ route('shop.index') }}">Lihat semua produk</a></div>@endforelse</div>
</section>
<section class="foot-banner"><div><span class="eyebrow">TEMUKAN FIT YANG PAS</span><h2>Langkah nyaman dimulai dari ukuran yang tepat.</h2><p class="sub">Gunakan panduan ukuran sebelum memilih pasangan berikutnya.</p></div><a class="pill" href="{{ route('shop.sizes') }}">Buka panduan ukuran →</a></section>
@endsection
