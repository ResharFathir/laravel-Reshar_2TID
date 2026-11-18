<article class="card">
    <div class="pic">
        @if ($p->type === 'sepatu' && $p->is_trending)<span class="tag">Trending</span>@endif
        @if ($p->type === 'sepatu')
            @include('partials.shoe', ['a' => $p->color_1, 'b' => $p->color_2 ?? '#FFFFFF'])
        @else
            @include('partials.box', ['c' => $p->color_1])
        @endif
    </div>
    <h3>{{ $p->full_name }}</h3>
    <span class="price">{{ $p->price_rp }}</span>
    <button class="add" type="button" data-n="{{ $p->name }}">Tambah</button>
</article>
