@extends('bumalo.admin-layout')
@section('title', 'AI Commerce Dashboard · Bumalo')
@section('content')
<section class="section ai-dashboard">
    <header class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="ai-kicker"><span class="ai-spark">✦</span> BUMALO AI COMMERCE INTELLIGENCE</span>
            <h1>Selamat datang, {{ auth()->user()->name }}.</h1>
            <p>Pantau performa toko dan temukan peluang berikutnya dari satu ruang kerja.</p>
        </div>
        <div class="dashboard-hero-actions">
            <span class="dashboard-date">{{ now()->format('d M Y') }}</span>
            @if(in_array(auth()->user()->role,['admin','owner']))<a class="ai-button ai-button-primary" href="{{ route('admin.products.create') }}">+ Tambah produk</a>@endif
        </div>
        <div class="hero-orbit orbit-one"></div><div class="hero-orbit orbit-two"></div>
    </header>

    <div class="kpi-grid">
        <article class="kpi-card kpi-revenue"><div class="kpi-top"><span>Penjualan terverifikasi</span><span class="kpi-icon">Rp</span></div><strong>Rp{{ number_format($sales,0,',','.') }}</strong><small>Periode {{ ['day'=>'hari','month'=>'bulan','year'=>'tahun'][$period] }} yang dipilih</small></article>
        <article class="kpi-card"><div class="kpi-top"><span>Pesanan di periode ini</span><span class="kpi-icon">&#8599;</span></div><strong>{{ number_format($periodOrderCount) }}</strong><small>{{ number_format($orderCount) }} pesanan sepanjang waktu</small></article>
        <article class="kpi-card"><div class="kpi-top"><span>Menunggu verifikasi</span><span class="kpi-icon kpi-icon-warn">!</span></div><strong>{{ number_format($pendingPayments) }}</strong><small>Perlu tindak lanjut admin</small></article>
        <article class="kpi-card"><div class="kpi-top"><span>Produk aktif & stok</span><span class="kpi-icon">&#9638;</span></div><strong>{{ number_format($productCount) }} <small class="kpi-unit">produk</small></strong><small>{{ number_format($stockUnits) }} pasang · {{ $lowStock->count() }} stok menipis</small></article>
    </div>

    <div class="analytics-card">
        <div class="analytics-heading"><div><span class="ai-kicker ai-kicker-dark">ANALITIK PENJUALAN</span><h2>Performa toko</h2><p>Nilai transaksi dari pesanan yang sudah diproses, dikirim, atau selesai.</p></div>
            <form class="analytics-controls" method="get" action="{{ route('admin.dashboard') }}">
                <select name="period" id="period-select" aria-label="Periode grafik"><option value="day" @selected($period==='day')>Harian</option><option value="month" @selected($period==='month')>Bulanan</option><option value="year" @selected($period==='year')>Tahunan</option></select>
                @if($period==='day')<input type="date" name="date" value="{{ $dateValue }}" aria-label="Pilih tanggal">@elseif($period==='month')<input type="month" name="date" value="{{ $dateValue }}" aria-label="Pilih bulan">@else<input type="number" name="date" value="{{ $dateValue }}" min="1900" max="9999" aria-label="Pilih tahun">@endif
                <input type="hidden" name="chart_type" id="chart-type-input" value="{{ request('chart_type','bar') }}">
                <input type="hidden" name="chart_metric" id="chart-metric-input" value="{{ request('chart_metric','sales') }}">
                <button class="ai-button ai-button-filter" type="submit">Terapkan</button>
            </form>
        </div>
        <div class="chart-toolbar"><div class="chart-legend"><span class="legend-dot"></span><span id="chart-legend-label">Penjualan</span><strong class="chart-total" id="chart-legend-total">Rp{{ number_format($sales,0,',','.') }}</strong></div><div class="chart-options"><div class="chart-data-switch" role="group" aria-label="Data grafik"><button type="button" data-chart-metric="sales">Penjualan</button><button type="button" data-chart-metric="orders">Pesanan</button></div><div class="chart-switch" role="group" aria-label="Jenis grafik"><button type="button" data-chart-mode="bar">Batang</button><button type="button" data-chart-mode="line">Garis</button></div></div></div>
        <div class="sales-chart-wrap"><svg id="sales-chart" class="sales-chart" viewBox="0 0 900 330" role="img" aria-label="Grafik penjualan"></svg></div>
        <div id="chart-tooltip" class="chart-tooltip" aria-live="polite"></div>
    </div>

    <div class="insight-grid">
        <article class="insight-card"><div class="insight-orb">✦</div><div><span class="ai-kicker ai-kicker-dark">SMART STORE INSIGHT</span><h3>Fokus peluangmu berikutnya</h3><p>{{ $insight }}</p></div></article>
        <article class="mini-stat-card"><span>Pesanan periode ini</span><strong>{{ number_format($periodOrderCount) }}</strong><small>{{ number_format($chart->sum('orders')) }} aktivitas tercatat pada grafik</small></article>
    </div>

    <div class="dashboard-grid dashboard-grid-main">
        <section class="dashboard-panel"><div class="panel-heading"><div><span class="ai-kicker ai-kicker-dark">PERFORMA PRODUK</span><h2>Produk terlaris</h2></div><span class="panel-badge">{{ ['day'=>'HARI INI','month'=>'BULAN INI','year'=>'TAHUN INI'][$period] }}</span></div>
            @forelse($topProducts as $index => $item)<div class="top-product-row"><span class="product-rank">{{ str_pad($index+1,2,'0',STR_PAD_LEFT) }}</span><div class="top-product-copy"><strong>{{ $item->product_name }}</strong><small>Terjual {{ number_format($item->quantity) }} pasang</small></div><div class="rank-meter"><span style="width:{{ max(12, (int)($item->quantity / max(1,$topProducts->max('quantity')) * 100)) }}%"></span></div></div>@empty<div class="panel-empty">Belum ada penjualan terverifikasi pada periode ini.</div>@endforelse
        </section>
        <section class="dashboard-panel"><div class="panel-heading"><div><span class="ai-kicker ai-kicker-dark">ORDER HEALTH</span><h2>Status pesanan</h2></div><span class="panel-badge">SEMUA WAKTU</span></div>
            @php($statusLabels=['pending_payment'=>'Menunggu bayar','payment_review'=>'Verifikasi bayar','processing'=>'Dikemas','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'])
            @foreach($statusLabels as $key=>$label)<div class="status-line"><span><i class="status-dot status-{{ $key }}"></i>{{ $label }}</span><strong>{{ number_format($statusCounts->get($key,0)) }}</strong></div>@endforeach
        </section>
    </div>

    <div class="dashboard-grid dashboard-grid-orders">
        <section class="dashboard-panel"><div class="panel-heading"><div><span class="ai-kicker ai-kicker-dark">AKTIVITAS TOKO</span><h2>Pesanan terbaru</h2><p>Maksimal 40 pesanan terakhir.</p></div></div>
            @forelse($orders as $order)<article class="admin-order ai-order-card"><div class="row"><div><b>{{ $order->code }}</b><div class="muted small">{{ $order->customer_name }} · {{ $order->phone }}</div><div class="muted small">{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div></div><span class="status">{{ strtoupper(str_replace('_',' ',$order->status)) }}</span></div>
                <div class="small muted ai-order-items" style="margin:12px 0">@foreach($order->items as $item){{ $item->product_name }} ({{ $item->size }}) ×{{ $item->quantity }}@if(!$loop->last), @endif @endforeach · <b>Rp{{ number_format($order->total,0,',','.') }}</b></div>
                @if($order->payment?->proof_path && in_array(auth()->user()->role,['admin','owner']))<a class="small ai-proof-link" target="_blank" href="{{ route('admin.payments.proof',$order) }}">Lihat bukti pembayaran ↗</a>@endif
                @if($order->status==='payment_review' && in_array(auth()->user()->role,['admin','owner']))<form method="post" action="{{ route('admin.payments.verify',$order) }}" class="ai-order-actions">@csrf<input class="field" name="note" placeholder="Catatan (opsional)"><button class="ai-button ai-button-primary" name="decision" value="approve">Verifikasi</button><button class="ai-button ai-button-quiet" name="decision" value="reject">Tolak</button></form>@endif
                @if($order->status==='processing')<form method="post" action="{{ route('admin.orders.ship',$order) }}" class="ai-order-actions">@csrf<input class="field" name="courier" placeholder="Kurir" required><input class="field" name="tracking_number" placeholder="Nomor resi" required><button class="ai-button ai-button-primary">Simpan resi</button></form>@endif
            </article>@empty<div class="panel-empty">Belum ada pesanan.</div>@endforelse
        </section>
        <aside class="dashboard-panel stock-panel"><div class="panel-heading"><div><span class="ai-kicker ai-kicker-dark">INVENTORY RADAR</span><h2>Stok menipis</h2><p>Ambang batas 3 pasang.</p></div><span class="stock-count">{{ $lowStock->count() }}</span></div>
            @forelse($lowStock as $variant)<div class="low-stock-row"><div><strong>{{ $variant->product->name }}</strong><small>Ukuran EU {{ $variant->size }}</small></div><span>{{ $variant->stock }} <small>pasang</small></span></div>@empty<div class="panel-empty">Semua stok masih aman.</div>@endforelse
            @if(in_array(auth()->user()->role,['admin','owner']))<a class="inventory-link" href="{{ route('admin.products.index',['stok'=>'tersedia']) }}">Kelola inventaris <span>→</span></a>@endif
        </aside>
    </div>
</section>
<script>
(() => {
    const svg = document.getElementById('sales-chart');
    const values = @json($chart->pluck('total')->values());
    const orderValues = @json($chart->pluck('orders')->values());
    const labels = @json($chart->pluck('label')->values());
    const modeInput = document.getElementById('chart-type-input');
    const metricInput = document.getElementById('chart-metric-input');
    const switcher = document.querySelector('.chart-switch');
    const metricSwitcher = document.querySelector('.chart-data-switch');
    const legendLabel = document.getElementById('chart-legend-label');
    const legendTotal = document.getElementById('chart-legend-total');
    const periodSelect = document.getElementById('period-select');
    const dateInput = document.querySelector('.analytics-controls [name="date"]');
    if (periodSelect && dateInput) periodSelect.addEventListener('change', () => {
        const now = new Date(), year = now.getFullYear(), month = String(now.getMonth()+1).padStart(2,'0'), day = String(now.getDate()).padStart(2,'0');
        const formats = {day:['date',`${year}-${month}-${day}`],month:['month',`${year}-${month}`],year:['number',`${year}`]};
        const [type,value] = formats[periodSelect.value]; dateInput.type = type; dateInput.value = value;
    });
    if (!svg || !switcher) return;
    const ns = 'http://www.w3.org/2000/svg';
    const width = 900, height = 330, left = 68, right = 18, top = 18, bottom = 42;
    const chartWidth = width - left - right, chartHeight = height - top - bottom;
    let metric = metricInput?.value === 'orders' ? 'orders' : 'sales';
    let activeMode = modeInput?.value === 'line' ? 'line' : 'bar';
    const formatValue = value => metric === 'sales' ? 'Rp' + new Intl.NumberFormat('id-ID').format(value) : new Intl.NumberFormat('id-ID').format(value) + ' pesanan';
    const formatAxis = value => metric === 'sales' && value >= 1000000 ? 'Rp' + new Intl.NumberFormat('id-ID',{maximumFractionDigits:1}).format(value/1000000) + ' jt' : new Intl.NumberFormat('id-ID').format(value);
    function node(name, attrs = {}) { const element = document.createElementNS(ns, name); Object.entries(attrs).forEach(([key, value]) => element.setAttribute(key, value)); return element; }
    function render(mode) {
        svg.replaceChildren();
        const pointsData = metric === 'sales' ? values : orderValues;
        const max = Math.max(1, ...pointsData);
        for (let line = 0; line <= 4; line++) {
            const y = top + chartHeight * line / 4;
            svg.append(node('line', {x1:left,y1:y,x2:width-right,y2:y,stroke:'#e8ebf3','stroke-width':1}));
            const label = node('text', {x:left-12,y:y+4,'text-anchor':'end',fill:'#9299aa','font-size':10});
            label.textContent = line === 4 ? '0' : formatAxis(Math.round(max * (4-line) / 4)); svg.append(label);
        }
        const step = chartWidth / pointsData.length;
        const points = pointsData.map((value, index) => ({x:left+step*(index+.5), y:top+chartHeight-(value/max)*chartHeight, value, label:labels[index]}));
        const tickEvery = Math.max(1, Math.ceil(labels.length / 12));
        points.forEach((point,index) => { if (index % tickEvery === 0 || index === points.length-1) { const label=node('text',{x:point.x,y:height-12,'text-anchor':'middle',fill:'#9299aa','font-size':10}); label.textContent=point.label; svg.append(label); } });
        if (mode === 'bar') {
            const defs=node('defs'), gradient=node('linearGradient',{id:'salesGradient',x1:'0',y1:'0',x2:'0',y2:'1'}); gradient.append(node('stop',{offset:'0%','stop-color':'#a59cff'})); gradient.append(node('stop',{offset:'100%','stop-color':'#6d62df'})); defs.append(gradient); svg.prepend(defs);
            points.forEach(point => { const rect=node('rect',{x:point.x-step*.31,y:point.y,width:step*.62,height:Math.max(2,top+chartHeight-point.y),rx:5,fill:'url(#salesGradient)'}); const title=node('title'); title.textContent=point.label+': '+formatValue(point.value); rect.append(title); svg.append(rect); });
        } else {
            const defs=node('defs'), gradient=node('linearGradient',{id:'lineGradient',x1:'0',y1:'0',x2:'0',y2:'1'}); gradient.append(node('stop',{offset:'0%','stop-color':'#8273ff','stop-opacity':'.22'})); gradient.append(node('stop',{offset:'100%','stop-color':'#8273ff','stop-opacity':'0'})); defs.append(gradient); svg.append(defs);
            const path=points.map((point,index)=>(index?'L':'M')+' '+point.x+' '+point.y).join(' '); const area=path+' L '+points[points.length-1].x+' '+(top+chartHeight)+' L '+points[0].x+' '+(top+chartHeight)+' Z'; svg.append(node('path',{d:area,fill:'url(#lineGradient)'})); svg.append(node('path',{d:path,fill:'none',stroke:'#7668f5','stroke-width':3,'stroke-linecap':'round','stroke-linejoin':'round'}));
            points.forEach(point => { const circle=node('circle',{cx:point.x,cy:point.y,r:4,fill:'#fff',stroke:'#7668f5','stroke-width':3,tabindex:0}); const title=node('title'); title.textContent=point.label+': '+formatValue(point.value); circle.append(title); svg.append(circle); });
        }
        switcher.querySelectorAll('button').forEach(button=>button.classList.toggle('active',button.dataset.chartMode===mode));
        if(modeInput) modeInput.value=mode; activeMode=mode;
        if(metricSwitcher) metricSwitcher.querySelectorAll('button').forEach(button=>button.classList.toggle('active',button.dataset.chartMetric===metric));
        if(metricInput) metricInput.value=metric;
        if(legendLabel) legendLabel.textContent=metric==='sales'?'Penjualan':'Jumlah pesanan';
        if(legendTotal) legendTotal.textContent=metric==='sales'?'Rp'+new Intl.NumberFormat('id-ID').format(values.reduce((sum,value)=>sum+value,0)):new Intl.NumberFormat('id-ID').format(orderValues.reduce((sum,value)=>sum+value,0))+' pesanan';
    }
    switcher.addEventListener('click', event => { const button=event.target.closest('[data-chart-mode]'); if(button) render(button.dataset.chartMode); });
    metricSwitcher?.addEventListener('click', event => { const button=event.target.closest('[data-chart-metric]'); if(button){ metric=button.dataset.chartMetric; render(activeMode); } });
    render(activeMode);
})();
</script>
@endsection
