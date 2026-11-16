@extends('layouts.admin')
@section('title', 'Produk')

@section('content')
<h1>Produk</h1>
<p><a class="btn" href="{{ route('admin.products.create') }}">Tambah produk</a></p>
<br>
<table>
    <tr><th>Nama</th><th>Jenis</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Trending</th><th></th></tr>
    @forelse ($products as $p)
        <tr>
            <td>{{ $p->full_name }}</td>
            <td>{{ $p->type }}</td>
            <td>{{ $p->type === 'sepatu' ? $p->gender : $p->group }}</td>
            <td>{{ $p->price_rp }}</td>
            <td>{{ $p->stock }}</td>
            <td>{{ $p->is_trending ? 'Ya' : '-' }}</td>
            <td style="white-space:nowrap">
                <a class="btn out" href="{{ route('admin.products.edit', $p) }}">Ubah</a>
                <form method="POST" action="{{ route('admin.products.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button class="btn danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="7">Belum ada produk. Tambahkan produk pertama.</td></tr>
    @endforelse
</table>
<br>{{ $products->links() }}
@endsection
