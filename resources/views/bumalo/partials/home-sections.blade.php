{{-- Beranda: banner merek, deretan merek, banner promo, kategori foto, pembayaran --}}
@php
    // Ilustrasi sepatu sederhana (ganti dengan <img> foto asli kalau sudah ada)
    $shoe = function ($a, $b) {
        return '<svg viewBox="0 0 120 70" aria-hidden="true"><path d="M8 46C8 30 20 22 34 24l14 4c10 2 18-8 30-4 18 6 34 14 34 22z" fill="'.$a.'"/><path d="M40 27l6 8M50 29l6 8M60 27l6 8" stroke="'.$b.'" stroke-width="3" stroke-linecap="round"/><path d="M6 46h108v8q0 6-8 6H14q-8 0-8-6z" fill="'.$b.'"/></svg>';
    };

    // ===== EDIT DI SINI =====
    $banner = ['brand' => 'asics', 'kata1' => 'All-time cl', 'kata2' => 'asics', 'tombol' => 'Belanja Gel-Kayano',
               'link' => route('shop.index', ['kategori' => 'Pria'])];

    $promoKiri  = ['baris1' => 'BELI 2', 'baris2' => 'DAPAT', 'besar' => '20', 'ket' => 'DISKON'];
    $promoKanan = ['baris1' => 'BELI 3', 'baris2' => 'DAPAT', 'besar' => '30', 'ket' => 'DISKON'];
    $promoTengah = ['judul' => 'T-SHIRT DEALS', 'catatan' => '*untuk produk pilihan, S&K berlaku', 'tombol' => 'Belanja Sekarang',
                    'link' => route('shop.index', ['kategori' => 'Accessories'])];

    // [teks besar, link, foto di public/images, warna cadangan bila foto belum ada]
    $tiles = [
        ['ACCESSORIES & APPAREL', route('shop.index', ['kategori' => 'Accessories']), 'images/kategori-accessories.jpg', '#6b7280'],
        ['PRIA',      route('shop.index', ['kategori' => 'Pria']),      'images/kategori-pria.jpg',      '#4b5563'],
        ['WANITA',    route('shop.index', ['kategori' => 'Wanita']),    'images/kategori-wanita.jpg',    '#6b7280'],
        ['ANAK-ANAK', route('shop.index', ['kategori' => 'Anak-anak']), 'images/kategori-anak.jpg',      '#4b5563'],
    ];

    $pay = ['QRIS', 'BCA', 'Mandiri', 'BRI', 'Visa', 'Mastercard'];
@endphp

<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bumalo-home.css') }}">

<div class="bh">

    {{-- 1. Banner merek --}}
    <section class="bh-brandbar">
        <span class="bh-logo">{{ $banner['brand'] }}</span>
        <h2>{{ $banner['kata1'] }}<b>{{ $banner['kata2'] }}</b></h2>
        <div class="bh-shoes">
            {!! $shoe('#d8dde4', '#3a4256') !!}
            {!! $shoe('#b9c6d4', '#3a4256') !!}
            {!! $shoe('#eef1f5', '#4b6384') !!}
        </div>
        <a class="bh-ghost" href="{{ $banner['link'] }}">{{ $banner['tombol'] }}</a>
    </section>

    {{-- 2. Deretan merek (dari tabel brands) --}}
    @if (!empty($brands) && count($brands))
        <nav class="bh-brands" aria-label="Merek">
            @foreach ($brands as $b)
                <a href="{{ route('shop.index', ['brand' => $b->id]) }}">{{ $b->name }}</a>
            @endforeach
        </nav>
    @endif

    {{-- 3. Banner promo --}}
    <section class="bh-promo">
        @foreach ([$promoKiri, null, $promoKanan] as $p)
            @if ($p)
                <div class="bh-offer">
                    <span class="bh-l1">{{ $p['baris1'] }} <em>{{ $p['baris2'] }}</em></span>
                    <span class="bh-big">{{ $p['besar'] }}<sup>%*</sup></span>
                    <span class="bh-off">{{ $p['ket'] }}</span>
                </div>
            @else
                <div class="bh-center">
                    <svg viewBox="0 0 120 110" aria-hidden="true"><path d="M30 10L45 4Q60 16 75 4L90 10L112 32L98 46L86 36V102H34V36L22 46L8 32Z" fill="#f4f4f4" stroke="#d4d4d4" stroke-width="2"/></svg>
                    <span class="bh-tag">bumalo.id</span>
                    <strong>{{ $promoTengah['judul'] }}</strong>
                    <small>{{ $promoTengah['catatan'] }}</small>
                    <a class="bh-shop" href="{{ $promoTengah['link'] }}">{{ $promoTengah['tombol'] }}</a>
                </div>
            @endif
        @endforeach
    </section>

    {{-- 4. Kategori foto besar --}}
    <section class="bh-tiles">
               @foreach ($tiles as $t)
            @php
                $css = 'background-color:' . $t[3]
                    . ';background-image:linear-gradient(180deg,rgba(0,0,0,0) 45%,rgba(0,0,0,.6)),url(' . asset($t[2]) . ')';
                $styleAttr = 'style="' . e($css) . '"';
            @endphp
            <a class="bh-tile" href="{{ $t[1] }}" {!! $styleAttr !!}>
                <span>{{ $t[0] }}</span>
            </a>
        @endforeach
    </section>

    {{-- 5. Opsi pembayaran --}}
    <section class="bh-pay">
        <div>
            <strong>Opsi Pembayaran Aman</strong>
            <p>Belanja dengan tenang memakai metode pembayaran pilihanmu</p>
        </div>
        <div class="bh-chips">
            @foreach ($pay as $m)<span class="bh-chip">{{ $m }}</span>@endforeach
        </div>
    </section>
</div>