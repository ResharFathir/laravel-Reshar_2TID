@extends('bumalo.layout')
@section('title', 'Dashboard admin - Bumalo.id')
@section('content')
<section class="section">
    <div class="admin-title">
        <div><span class="eyebrow">DASHBOARD SISTEM</span><h1 style="font:800 36px Manrope;letter-spacing:-1.5px;margin:12px 0 0">Halo, {{ auth()->user()->name }}</h1><p class="sub">Ringkasan toko dan aktivitas terbaru.</p></div>
        @if(in_array(auth()->user()->role,['admin','owner']))<div style="display:flex;gap:8px;flex-wrap:wrap"><a class="pill dark" href="{{ route('admin.products.index') }}">Kelola produk</a><a class="pill" href="{{ route('admin.accounts.index') }}">Kelola akun</a></div>@endif
    </div>

    <div class="metrics">
        <div class="metric"><span class="muted">Total penjualan terverifikasi</span><strong>Rp{{ number_format($sales, 0, ',', '.') }}</strong></div>
        <div class="metric"><span class="muted">Seluruh pesanan</span><strong>{{ number_format($orderCount) }}</strong></div>
        <div class="metric"><span class="muted">Perlu verifikasi bayar</span><strong>{{ number_format($pendingPayments) }}</strong></div>
        <div class="metric"><span class="muted">Produk katalog</span><strong>{{ number_format($productCount) }}</strong></div>
        <div class="metric"><span class="muted">Total stok pasang</span><strong>{{ number_format($stockUnits) }}</strong></div>
        <div class="metric"><span class="muted">Pelanggan / akun tim</span><strong>{{ $customerCount }} / {{ $staffCount }}</strong></div>
    </div>

    <div class="columns" style="grid-template-columns:1.2fr .8fr;align-items:stretch">
        <div class="card"><div class="section-head"><div><h2 style="font-size:22px">Penjualan 7 hari</h2><p class="sub">Nilai dari pembayaran yang sudah diverifikasi.</p></div></div><div style="height:190px;display:flex;align-items:end;gap:12px;padding-top:18px">@php($maxSales=max(1,(int)$chart->max('total')))
            @foreach($chart as $day)<div style="flex:1;text-align:center"><div title="Rp{{ number_format($day['total'],0,',','.') }}" style="height:{{ max(5,(int)($day['total']/$maxSales*145)) }}px;background:#b8f36b;border-radius:8px 8px 3px 3px"></div><small class="muted">{{ $day['label'] }}</small></div>@endforeach
        </div></div>
        <div class="card"><h2 style="font-size:22px;margin-top:0">Status pesanan</h2>@php($statusLabels=['pending_payment'=>'Menunggu bayar','payment_review'=>'Verifikasi bayar','processing'=>'Dikemas','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'])
            @foreach($statusLabels as $key=>$label)<div class="total-row"><span class="muted">{{ $label }}</span><strong>{{ $statusCounts->get($key,0) }}</strong></div>@endforeach
        </div>
    </div>

    <div class="columns" style="grid-template-columns:1.35fr .65fr;align-items:start;margin-top:34px">
        <div><div class="section-head"><div><h2 style="font-size:25px">Pesanan terbaru</h2><p class="sub">Maksimal 40 pesanan terakhir.</p></div></div>
            @forelse($orders as $order)<article class="admin-order">
                <div class="row"><div><b>{{ $order->code }}</b><div class="muted small">{{ $order->customer_name }} · {{ $order->phone }}</div><div class="muted small">{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div></div><span class="status">{{ strtoupper(str_replace('_',' ',$order->status)) }}</span></div>
                <div class="small muted" style="margin:12px 0">@foreach($order->items as $item){{ $item->product_name }} ({{ $item->size }}) ×{{ $item->quantity }}@if(!$loop->last), @endif @endforeach · <b>Rp{{ number_format($order->total,0,',','.') }}</b></div>
                @if($order->payment?->proof_path && in_array(auth()->user()->role,['admin','owner']))<a class="small" target="_blank" href="{{ route('admin.payments.proof',$order) }}">Lihat bukti pembayaran</a>@endif
                @if($order->status==='payment_review' && in_array(auth()->user()->role,['admin','owner']))<form method="post" action="{{ route('admin.payments.verify',$order) }}" style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px">@csrf<input class="field" name="note" placeholder="Catatan (opsional)" style="flex:1;min-width:160px"><button class="pill" name="decision" value="approve">Verifikasi</button><button class="pill line" name="decision" value="reject">Tolak</button></form>@endif
                @if($order->status==='processing')<form method="post" action="{{ route('admin.orders.ship',$order) }}" style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px">@csrf<input class="field" name="courier" placeholder="Kurir" required style="max-width:150px"><input class="field" name="tracking_number" placeholder="Nomor resi" required style="flex:1;min-width:150px"><button class="pill dark">Simpan resi</button></form>@endif
            </article>@empty<div class="card">Belum ada pesanan.</div>@endforelse
        </div>
        <aside><div class="section-head"><div><h2 style="font-size:25px">Stok menipis</h2><p class="sub">Ambang stok 3 pasang.</p></div></div><div class="card">@forelse($lowStock as $variant)<div style="padding:12px 0;border-bottom:1px solid var(--line)"><b>{{ $variant->product->name }} · EU {{ $variant->size }}</b><div class="muted small">Sisa {{ $variant->stock }} pasang</div></div>@empty<p class="muted">Semua stok masih cukup.</p>@endforelse</div></aside>
    </div>
</section>
@endsection
