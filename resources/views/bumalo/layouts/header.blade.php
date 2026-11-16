<div class="util"><div><span>Cari Toko</span><span>Bantuan</span><span>Gabung</span><span>Masuk</span></div></div>
<header>
    <div class="bar">
        <a href="{{ route('toko.home') }}" class="logo">bumalo<i>.id</i></a>
        <nav>
            <a href="{{ route('toko.home') }}" class="{{ request()->routeIs('toko.home') ? 'on' : '' }}">Home</a>
            <a href="{{ route('toko.trending') }}" class="{{ request()->routeIs('toko.trending') ? 'on' : '' }}">Trending</a>
            <div class="dd">
                <button aria-haspopup="true">Kategori</button>
                <div class="menu">
                    <a href="{{ route('toko.kategori', 'pria') }}">Pria</a>
                    <a href="{{ route('toko.kategori', 'wanita') }}">Wanita</a>
                    <a href="{{ route('toko.kategori', 'anak') }}">Anak-anak</a>
                </div>
            </div>
            <a href="{{ route('toko.accessories') }}" class="{{ request()->routeIs('toko.accessories') ? 'on' : '' }}">Accessories</a>
        </nav>
        <div class="tools">
            <form action="{{ route('toko.cari') }}" method="GET">
                <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Cari sepatu" aria-label="Cari sepatu">
            </form>
            <button class="cart" id="cart" type="button">Keranjang (0)</button>
        </div>
    </div>
</header>
<div class="ann">Gratis ongkir min. Rp500.000 &amp; retur 7 hari<b>Gabung sekarang</b></div>
