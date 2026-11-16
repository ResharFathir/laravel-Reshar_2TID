@if ($products->isEmpty())
    <div class="empty">Produk tidak ditemukan. Coba kata kunci atau merek lain.</div>
@else
    <div class="grid">
        @foreach ($products as $p)
            @include('bumalo.partials.card', ['p' => $p])
        @endforeach
    </div>
@endif
