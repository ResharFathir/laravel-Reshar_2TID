@csrf
<div class="form">
    <label class="full">Nama produk
        <input name="name" value="{{ old('name', $product->name) }}" required>
        @error('name')<span class="err">{{ $message }}</span>@enderror
    </label>
    <label>Jenis
        <select name="type">
            <option value="sepatu" @selected(old('type', $product->type) === 'sepatu')>Sepatu</option>
            <option value="accessory" @selected(old('type', $product->type) === 'accessory')>Accessory</option>
        </select>
    </label>
    <label>Harga (Rp)
        <input type="number" name="price" min="0" value="{{ old('price', $product->price) }}" required>
        @error('price')<span class="err">{{ $message }}</span>@enderror
    </label>
    <label>Merek (sepatu)
        <select name="brand">
            <option value="">-</option>
            @foreach (\App\Models\Product::BRANDS as $b)
                <option @selected(old('brand', $product->brand) === $b)>{{ $b }}</option>
            @endforeach
        </select>
        @error('brand')<span class="err">{{ $message }}</span>@enderror
    </label>
    <label>Kategori (sepatu)
        <select name="gender">
            <option value="">-</option>
            @foreach (\App\Models\Product::GENDERS as $k => $v)
                <option value="{{ $k }}" @selected(old('gender', $product->gender) === $k)>{{ $v }}</option>
            @endforeach
        </select>
        @error('gender')<span class="err">{{ $message }}</span>@enderror
    </label>
    <label>Grup (accessory, mis. Kaos kaki)
        <input name="group" value="{{ old('group', $product->group) }}">
    </label>
    <label>Stok
        <input type="number" name="stock" min="0" value="{{ old('stock', $product->stock ?? 20) }}" required>
    </label>
    <label>Warna utama
        <input type="color" name="color_1" value="{{ old('color_1', $product->color_1) }}">
    </label>
    <label>Warna aksen
        <input type="color" name="color_2" value="{{ old('color_2', $product->color_2 ?? '#ffffff') }}">
    </label>
    <label class="full" style="flex-direction:row;align-items:center;gap:8px">
        <input type="checkbox" name="is_trending" value="1" @checked(old('is_trending', $product->is_trending))> Tampilkan di Trending
    </label>
</div>
<br>
<button class="btn">Simpan</button>
<a class="btn out" href="{{ route('admin.products.index') }}">Batal</a>
