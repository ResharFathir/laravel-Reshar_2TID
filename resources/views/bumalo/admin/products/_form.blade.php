<style>
    .edit-head{display:flex;justify-content:space-between;align-items:flex-end;gap:15px;margin:18px 0 22px}.edit-head h1{font:800 30px Manrope;margin:5px 0}.edit-head p{margin:0;color:#77837c}.edit-grid{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(280px,.8fr);gap:18px}.edit-card{background:#fff;border:1px solid #e7ebe4;border-radius:16px;padding:22px;margin-bottom:16px}.edit-card h2{font:800 17px Manrope;margin:0 0 5px}.edit-card>p{font-size:13px;color:#77837c;margin:0 0 18px}.edit-fields{display:grid;grid-template-columns:1fr 1fr;gap:14px}.edit-field{display:grid;gap:7px}.edit-field.full{grid-column:1/-1}.edit-field label,.variant-head{font-size:12px;font-weight:700;color:#526057}.edit-field input,.edit-field select,.edit-field textarea,.variant-row input{width:100%;border:1px solid #dfe5dc;background:#fff;border-radius:9px;padding:11px 12px;color:#26352d}.edit-field textarea{min-height:110px;resize:vertical}.edit-help{font-size:11px;color:#849087}.variant-list{display:grid;gap:9px}.variant-row{display:grid;grid-template-columns:1fr 1fr auto;gap:9px;align-items:center}.variant-row button{height:40px;width:40px;border:0;border-radius:9px;background:#fff0ed;color:#ad4539;font-size:18px;cursor:pointer}.variant-add{margin-top:12px;border:1px dashed #9aab9b;border-radius:9px;background:#f7faf5;color:#34513c;padding:10px 13px;font-weight:700;cursor:pointer}.edit-actions{display:flex;justify-content:flex-end;gap:9px;margin-top:17px}.edit-check{display:flex;align-items:center;gap:9px;padding:13px 0}.edit-check input{width:17px;height:17px;accent-color:#294b38}@media(max-width:780px){.edit-grid{grid-template-columns:1fr}}@media(max-width:520px){.edit-fields{grid-template-columns:1fr}.edit-field.full{grid-column:auto}.edit-head{align-items:flex-start;flex-direction:column}}
</style>
@php($isEditing = $product->exists)
<header class="edit-head"><div><span class="eyebrow">KATALOG TOKO</span><h1>{{ $isEditing ? 'Ubah produk' : 'Tambah produk' }}</h1><p>Lengkapi data produk dan stok pada setiap ukuran.</p></div><a class="product-btn light" href="{{ route('admin.products.index') }}">← Kembali ke produk</a></header>
<form method="post" action="{{ $isEditing ? route('admin.products.update',$product) : route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf @if($isEditing)@method('PUT')@endif
    <div class="edit-grid"><div>
        <section class="edit-card"><h2>Informasi produk</h2><p>Data ini akan tampil pada katalog toko.</p><div class="edit-fields">
            <div class="edit-field full"><label for="name">Nama produk</label><input id="name" name="name" value="{{ old('name',$product->name) }}" required maxlength="160" placeholder="Contoh: Aero Cloud Runner">@error('name')<span class="edit-help" style="color:#ad4539">{{ $message }}</span>@enderror</div>
            <div class="edit-field"><label for="brand_id">Merek</label><select id="brand_id" name="brand_id" required><option value="">Pilih merek</option>@foreach($brands as $brand)<option value="{{ $brand->id }}" @selected((string)old('brand_id',$product->brand_id)===(string)$brand->id)>{{ $brand->name }}</option>@endforeach</select>@error('brand_id')<span class="edit-help" style="color:#ad4539">{{ $message }}</span>@enderror</div>
            <div class="edit-field"><label for="category_id">Kategori</label><select id="category_id" name="category_id" required><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string)old('category_id',$product->category_id)===(string)$category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<span class="edit-help" style="color:#ad4539">{{ $message }}</span>@enderror</div>
            <div class="edit-field"><label for="price">Harga (Rp)</label><input id="price" name="price" type="number" min="0" max="100000000" value="{{ old('price',$product->price) }}" required>@error('price')<span class="edit-help" style="color:#ad4539">{{ $message }}</span>@enderror</div>
            <div class="edit-field"><label for="image">Foto produk</label><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"><span class="edit-help">JPG, PNG, atau WebP · maks. 4 MB</span>@error('image')<span class="edit-help" style="color:#ad4539">{{ $message }}</span>@enderror</div>
            <div class="edit-field full"><label for="description">Deskripsi</label><textarea id="description" name="description" maxlength="3000" placeholder="Ceritakan fitur dan kenyamanan produk">{{ old('description',$product->description) }}</textarea>@error('description')<span class="edit-help" style="color:#ad4539">{{ $message }}</span>@enderror</div>
        </div></section>
        <section class="edit-card"><h2>Ukuran dan stok</h2><p>Tambahkan setiap ukuran yang dijual beserta jumlah stoknya.</p><div class="variant-head" style="display:grid;grid-template-columns:1fr 1fr 40px;gap:9px;margin-bottom:8px"><span>Ukuran</span><span>Stok</span><span></span></div><div class="variant-list" id="variant-list">@foreach($variants as $i=>$variant)<div class="variant-row"><input name="variants[{{ $i }}][size]" value="{{ $variant['size'] }}" placeholder="EU 40" maxlength="8" aria-label="Ukuran" required><input name="variants[{{ $i }}][stock]" value="{{ $variant['stock'] }}" type="number" min="0" max="10000" placeholder="0" aria-label="Jumlah stok" required><button type="button" class="remove-variant" aria-label="Hapus ukuran">×</button></div>@endforeach</div><button type="button" class="variant-add" id="add-variant">＋ Tambah ukuran</button>@error('variants')<p class="edit-help" style="color:#ad4539">{{ $message }}</p>@enderror @error('variants.*.size')<p class="edit-help" style="color:#ad4539">{{ $message }}</p>@enderror</section>
    </div><aside><section class="edit-card"><h2>Status produk</h2><p>Produk nonaktif tidak tampil pada katalog toko.</p><label class="edit-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$product->is_active ?? true))><span>Aktif di toko</span></label><button class="product-btn" style="width:100%;margin-top:8px">{{ $isEditing ? 'Simpan perubahan' : 'Simpan produk' }}</button></section></aside></div>
</form>
<script>
(() => {
    const list = document.getElementById('variant-list');
    const add = document.getElementById('add-variant');
    let nextIndex = list.querySelectorAll('.variant-row').length;
    const bindRemove = (button) => button.addEventListener('click', () => {
        if (list.querySelectorAll('.variant-row').length > 1) button.closest('.variant-row').remove();
    });
    list.querySelectorAll('.remove-variant').forEach(bindRemove);
    add.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'variant-row';
        row.innerHTML = `<input name="variants[${nextIndex}][size]" placeholder="EU 40" maxlength="8" aria-label="Ukuran" required><input name="variants[${nextIndex}][stock]" type="number" min="0" max="10000" value="0" aria-label="Jumlah stok" required><button type="button" class="remove-variant" aria-label="Hapus ukuran">×</button>`;
        list.append(row);
        bindRemove(row.querySelector('.remove-variant'));
        nextIndex++;
    });
})();
</script>
