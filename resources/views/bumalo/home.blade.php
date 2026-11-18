@extends('bumalo.layouts.app')

@section('content')
@php
    $slides = [
        ['Samba season', 'Klasik lapangan yang kembali jadi andalan jalanan. Tampil santai, tetap rapi.', route('toko.trending'), 'Belanja Adidas', 'linear-gradient(120deg,#111,#2b2b2b)', '#F4F1E8', '#1B1B1B'],
        ['Lari tanpa ragu', 'Gel-Kayano dan seri lari lain dengan bantalan empuk untuk jarak jauh.', route('toko.kategori', 'pria'), 'Belanja sepatu lari', 'linear-gradient(120deg,#1d2a44,#4b6384)', '#C9D1DB', '#D9F24B'],
        ['Baru dari lokal', 'Mills dan Ortuseight: nyaman, tahan lama, harga bersahabat.', route('toko.kategori', 'pria'), 'Lihat koleksi', 'linear-gradient(120deg,#2a1d12,#6b3a1d)', '#FF7A3D', '#FFFFFF'],
    ];
    $labels = ['Exclusive', 'Drop baru', 'Pilihan kami', 'Baru datang'];
@endphp

{{-- Slide iklan --}}
<section class="slider" aria-roledescription="carousel">
    @foreach ($slides as $i => $s)
        <div class="slide {{ $i === 0 ? 'on' : '' }}" style="background:{{ $s[4] }}">
            <div>
                <h1>{{ $s[0] }}</h1>
                <p>{{ $s[1] }}</p>
                <a class="cta" href="{{ $s[2] }}">{{ $s[3] }}</a>
            </div>
            @include('bumalo.partials.shoe', ['a' => $s[5], 'b' => $s[6]])
        </div>
    @endforeach
    <button class="arr l" type="button" data-s="-1" aria-label="Sebelumnya">‹</button>
    <button class="arr r" type="button" data-s="1" aria-label="Berikutnya">›</button>
    <div class="dots">
        @foreach ($slides as $i => $s)
            <button type="button" data-d="{{ $i }}" class="{{ $i === 0 ? 'on' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>
        @endforeach
    </div>
</section>

{{-- Sepatu pilihan (campuran) --}}
<div class="pad">
    <section class="sec">
        <div class="head"><h2>Sepatu pilihan</h2><a href="{{ route('toko.trending') }}">Lihat semua</a></div>
        <div class="car">
            <div class="track" id="trk">
                @foreach ($featured as $p)
                    @include('bumalo.partials.card', ['p' => $p])
                @endforeach
            </div>
            <div class="dots" id="cd"></div>
        </div>
    </section>
</div>

{{-- Banner iklan --}}
<section class="sec">
    <div class="stripes"></div>
    <div class="tiles">
        @foreach ($featured->take(4)->values() as $i => $p)
            <a class="tile" href="{{ route('toko.trending') }}">
                @include('bumalo.partials.shoe', ['a' => $p->color_1, 'b' => $p->color_2 ?? '#FFFFFF'])
                <span class="sticker {{ $i % 2 ? 'dark' : '' }}">{{ $labels[$i] }}</span>
            </a>
        @endforeach
    </div>
    <div class="wide">
        <span class="brand">asics</span>
        <h2>All-time cl<b>asics</b></h2>
        <div class="shoes">
            @include('bumalo.partials.shoe', ['a' => '#d8dde4', 'b' => '#3a4256'])
            @include('bumalo.partials.shoe', ['a' => '#b9c6d4', 'b' => '#3a4256'])
            @include('bumalo.partials.shoe', ['a' => '#eef1f5', 'b' => '#4b6384'])
        </div>
        <a class="ghost" href="{{ route('toko.kategori', 'pria') }}?brand=Asics">Belanja Gel-Kayano</a>
    </div>
</section>
@endsection
