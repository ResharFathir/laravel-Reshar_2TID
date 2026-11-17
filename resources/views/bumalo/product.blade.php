@extends('bumalo.layout')
@section('title', $product->name.' - Bumalo.id')
@section('content')
<style>
    .variant-stock-label{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px;min-width:70px;min-height:64px;padding:8px 10px!important}.variant-stock-label b{font-size:15px}.variant-stock-label small{font-size:9px;color:#788078;white-space:nowrap}.size-option input:checked+.variant-stock-label small{color:#547d3e}.size-option input:disabled+.variant-stock-label small{color:#aaa}.stock-availability{min-height:23px;margin:14px 0 18px;color:#637069;font-size:13px}.stock-availability strong{color:#253b2c}.stock-availability.is-empty{color:#a34a40}.quantity-field{width:130px;margin:0 0 16px}.add-to-cart-button:disabled{opacity:.45;cursor:not-allowed;filter:grayscale(1)}
</style>
<div style="padding:28px 0;color:#798279;font-size:13px"><a href="{{ route('shop.index') }}">Beranda</a> / {{ $product->name }}</div>
<div class="columns">
    <div class="product-art" style="height:480px;border-radius:24px">@if($product->image)<img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:24px">@else<span class="shoe" style="font-size:170px">&#128095;</span>@endif</div>
    <div>
        <span class="eyebrow">{{ $product->brand->name }} · {{ $product->category->name }}</span>
        <h1 style="font:800 clamp(32px,4vw,48px) Manrope;letter-spacing:-2px;margin:18px 0">{{ $product->name }}</h1>
        <div class="price" style="font-size:24px">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
        <p class="muted" style="line-height:1.8">{{ $product->description }}</p>
        <form method="post" action="{{ route('cart.add') }}" class="card" style="padding:18px;margin-top:24px" data-product-form>
            @csrf
            <label>Pilih ukuran (EU)</label>
            @if($product->variants->isEmpty())
                <p class="stock-availability is-empty">Ukuran belum tersedia untuk produk ini.</p>
            @else
                <div class="size-options">
                    @foreach($product->variants as $variant)
                        @php($remaining = max(0, $variant->stock - (int) ($cart[$variant->id] ?? 0)))
                        <label class="size-option">
                            <input type="radio" name="variant_id" value="{{ $variant->id }}" data-stock="{{ $variant->stock }}" data-remaining="{{ $remaining }}" required @disabled($variant->stock === 0)>
                            <span class="variant-stock-label"><b>{{ $variant->size }}</b><small>{{ $variant->stock > 0 ? $variant->stock.' tersedia' : 'Habis' }}</small></span>
                        </label>
                    @endforeach
                </div>
                <p class="stock-availability" data-stock-message aria-live="polite">Pilih ukuran untuk melihat stok yang tersedia.</p>
            @endif
            <label for="quantity">Jumlah</label>
            <input id="quantity" class="field quantity-field" type="number" name="quantity" value="1" min="1" max="5" required disabled>
            <button class="pill dark add-to-cart-button" style="width:100%" type="submit" disabled data-add-button>Tambah ke keranjang</button>
        </form>
        <p class="small"><a href="{{ route('shop.sizes') }}">Lihat panduan ukuran &rarr;</a> &nbsp; · &nbsp; <a href="{{ route('shop.exchange') }}">Panduan tukar &rarr;</a></p>
    </div>
</div>
@push('scripts')
<script>
    (() => {
        const form = document.querySelector('[data-product-form]');
        const message = form.querySelector('[data-stock-message]');
        const quantity = form.querySelector('#quantity');
        const addButton = form.querySelector('[data-add-button]');
        const options = form.querySelectorAll('input[name="variant_id"]');

        options.forEach((option) => option.addEventListener('change', () => {
            const stock = Number(option.dataset.stock);
            const remaining = Number(option.dataset.remaining);
            message.classList.toggle('is-empty', stock === 0 || remaining === 0);

            if (remaining === 0) {
                message.textContent = stock > 0
                    ? `Stok ukuran ${option.nextElementSibling.querySelector('b').textContent} tersedia ${stock} pasang, tetapi seluruhnya sudah ada di keranjang.`
                    : `Ukuran ${option.nextElementSibling.querySelector('b').textContent} sedang habis.`;
                quantity.disabled = true;
                addButton.disabled = true;
                return;
            }

            message.textContent = `Stok tersedia untuk ukuran ${option.nextElementSibling.querySelector('b').textContent}: ${stock} pasang.`;
            if (remaining < stock) message.textContent += ` Maksimal tambahan ke keranjang: ${remaining} pasang.`;
            quantity.max = String(Math.min(5, remaining));
            quantity.value = String(Math.min(Math.max(1, Number(quantity.value) || 1), Number(quantity.max)));
            quantity.disabled = false;
            addButton.disabled = false;
        }));
    })();
</script>
@endpush
@endsection
