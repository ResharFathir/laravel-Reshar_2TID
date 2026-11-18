<article class="card">
    <div class="pic">
        @if ($p->type === 'sepatu' && $p->is_trending)<span class="tag">Trending</span>@endif
        @if ($p->type === 'sepatu')
            @include('bumalo.partials.shoe', ['a' => $p->color_1, 'b' => $p->color_2 ?? '#FFFFFF'])
        @else
            @include('bumalo.partials.box', ['c' => $p->color_1])
        @endif
    </div>
    <h3>{{ $p->full_name }}</h3>
    <span class="price">{{ $p->price_rp }}</span>
    <button class="add" type="button"
        data-id="{{ $p->id }}" data-n="{{ $p->full_name }}" data-p="{{ $p->price }}"
        data-t="{{ $p->type }}" data-g="{{ $p->gender }}" data-grp="{{ $p->group }}"
        data-c1="{{ $p->color_1 }}" data-c2="{{ $p->color_2 }}">Tambah</button>
</article>