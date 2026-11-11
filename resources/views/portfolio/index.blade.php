@extends('portfolio.layout')

@section('title', 'Beranda')

@push('styles')
<style>
    .hero { display:grid; grid-template-columns:minmax(0,1.5fr) minmax(0,.8fr); gap:clamp(28px,5vw,72px); align-items:end; padding-top:clamp(40px,7vw,88px); }
    .status { display:inline-flex; align-items:center; gap:10px; padding:8px 15px; border:1px solid var(--line); border-radius:999px; color:var(--muted); font-size:.85rem; }
    .pulse { width:8px; height:8px; border-radius:50%; background:#3ddc97; box-shadow:0 0 0 4px rgba(61,220,151,.2); }
    .hero-name { margin:24px 0 20px; font-family:'Syne',sans-serif; font-size:clamp(2.3rem,5.6vw,4.4rem); font-weight:700; letter-spacing:-.04em; line-height:1; }
    .hero-role { margin:0 0 10px; font-size:clamp(1.1rem,2vw,1.4rem); font-weight:600; }
    .hero-copy { max-width:520px; color:var(--muted); line-height:1.75; }
    .hero-actions { display:flex; flex-wrap:wrap; gap:10px; margin-top:28px; }
    .portrait { position:relative; aspect-ratio:4/5; overflow:hidden; border:1px solid var(--line); border-radius:28px 28px 28px 120px; background:var(--soft); }
    .portrait img { width:100%; height:100%; object-fit:cover; }
    .portrait-initials { display:grid; height:100%; place-items:center; color:var(--accent); font-family:'Syne',sans-serif; font-size:7rem; font-weight:800; }
    .portrait-chip { position:absolute; left:16px; bottom:16px; padding:8px 14px; border-radius:999px; background:color-mix(in srgb,var(--bg) 82%,transparent); backdrop-filter:blur(10px); font-size:.82rem; }
    .facts { display:grid; grid-template-columns:repeat(3,1fr); margin-top:clamp(36px,6vw,72px); border-top:1px solid var(--line); }
    .fact { padding:24px 0 0 24px; border-left:1px solid var(--line); }
    .fact:first-child { padding-left:0; border-left:0; }
    .fact-value { display:block; font-family:'Syne',sans-serif; font-size:clamp(1.8rem,4vw,3rem); font-weight:800; line-height:1; }
    .fact-label { color:var(--muted); font-size:.85rem; }
    .marquee { margin-top:clamp(36px,6vw,64px); padding:18px 0; overflow:hidden; border-block:1px solid var(--line); }
    .marquee-track { display:flex; width:max-content; animation:slide 40s linear infinite; }
    .marquee:hover .marquee-track { animation-play-state:paused; }
    .marquee-track span { margin-right:44px; color:var(--muted); font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:700; white-space:nowrap; }
    @keyframes slide { to { transform:translateX(-50%); } }

    .sec-head { display:flex; align-items:end; justify-content:space-between; gap:20px; margin:clamp(64px,9vw,112px) 0 28px; }
    .sec-title { margin:0; font-family:'Syne',sans-serif; font-size:clamp(2.1rem,5vw,3.6rem); font-weight:800; letter-spacing:-.035em; line-height:1; }
    .sec-copy { max-width:460px; margin:10px 0 0; color:var(--muted); }
    .tools { display:flex; flex-wrap:wrap; gap:12px; margin-bottom:30px; }
    .search-wrap { position:relative; flex:1 1 280px; }
    .search-wrap span { position:absolute; top:50%; left:16px; transform:translateY(-50%); color:var(--muted); }
    .control { min-height:48px; border:1px solid var(--line); border-radius:999px; background:var(--surface); color:var(--text); }
    .control:focus { border-color:var(--accent); background:var(--surface); color:var(--text); box-shadow:0 0 0 4px color-mix(in srgb,var(--accent) 22%,transparent); }
    .search-input { padding-left:44px; }

    .project-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:44px 26px; }
    .project-card[hidden] { display:none; }
    .project-visual { position:relative; display:grid; aspect-ratio:16/10; overflow:hidden; place-items:center; border:1px solid var(--line); border-radius:26px; background:linear-gradient(140deg,var(--soft),var(--surface)); }
    .project-visual img { width:100%; height:100%; object-fit:cover; transition:transform .6s; }
    .project-card:hover .project-visual img { transform:scale(1.045); }
    .project-fallback { color:var(--accent); font-family:'Syne',sans-serif; font-size:5rem; font-weight:800; opacity:.7; }
    .go { position:absolute; right:16px; bottom:16px; display:grid; width:46px; height:46px; place-items:center; border-radius:50%; background:var(--accent); color:var(--accent-ink); font-weight:700; transform:translateY(8px); opacity:0; transition:.25s; }
    .project-card:hover .go, .project-visual:focus-visible .go { transform:none; opacity:1; }
    .project-title { margin:18px 0 0; font-family:'Syne',sans-serif; font-size:1.55rem; font-weight:700; letter-spacing:-.02em; }
    .project-description { margin:8px 0 14px; color:var(--muted); font-size:.96rem; line-height:1.65; }
    .tech-tags { display:flex; flex-wrap:wrap; gap:7px; }
    .tech-tag { padding:5px 12px; border:1px solid var(--line); border-radius:999px; color:var(--muted); font-size:.78rem; }
    .project-actions { display:flex; flex-wrap:wrap; align-items:center; gap:16px; margin-top:16px; font-size:.86rem; }
    .project-actions a, .project-actions button { padding:0; border:0; background:none; color:var(--muted); text-decoration:none; }
    .project-actions a:hover, .project-actions button:hover { color:var(--accent); }
    .empty-state { grid-column:1/-1; padding:56px 24px; border:1px dashed var(--line); border-radius:28px; text-align:center; }
    .no-results { display:none; }

    .about { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
    .info-card { padding:clamp(24px,4vw,40px); border:1px solid var(--line); border-radius:28px; background:var(--surface); }
    .info-title { margin:0 0 22px; font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:700; }
    .skill-list { display:flex; flex-wrap:wrap; gap:10px; }
    .skill-pill { padding:9px 16px; border:1px solid var(--line); border-radius:999px; background:var(--soft); font-size:.9rem; }
    .education-list { margin:0; padding:0; list-style:none; }
    .education-list li { padding:14px 0; border-bottom:1px solid var(--line); color:var(--muted); }
    .education-list li:last-child { border-bottom:0; }

    .cta { margin:clamp(64px,9vw,112px) 0; padding:clamp(32px,6vw,76px); border-radius:36px; background:var(--accent); color:var(--accent-ink); }
    .cta h2 { max-width:760px; margin:0 0 18px; font-family:'Syne',sans-serif; font-size:clamp(2.2rem,6vw,4.6rem); font-weight:800; letter-spacing:-.04em; line-height:1; }
    .cta p { max-width:520px; margin:0 0 28px; opacity:.8; }
    .btn-ink { display:inline-flex; align-items:center; padding:.8rem 1.6rem; border:0; border-radius:999px; background:var(--accent-ink); color:var(--accent); font-weight:700; text-decoration:none; }
    .btn-ink:hover { color:var(--accent); filter:brightness(1.2); }
    .btn-ink-line { background:transparent; border:1px solid currentColor; color:var(--accent-ink); }
    .btn-ink-line:hover { color:var(--accent-ink); }

    @media (max-width:900px) { .hero { grid-template-columns:1fr; } .portrait { max-width:340px; } .about { grid-template-columns:1fr; } }
    @media (max-width:700px) { .project-grid { grid-template-columns:1fr; } .sec-head { flex-direction:column; align-items:flex-start; } .fact { padding-left:14px; } }
    @media print { .site-nav, .hero-actions, .tools, .project-actions, .cta, .marquee, .site-footer { display:none !important; } body { background:#fff; color:#111; } }
</style>
@endpush

@section('full')
@php
    $displayName = $profile?->name ?: 'Reshar Fathir Zuhri';
    $githubUrl = 'https://github.com/ResharFathir/laravel-Reshar_2TID';
    $nameParts = explode(' ', $displayName, 2);
    $skills = collect(preg_split('/\r\n|\r|\n/', (string) $profile?->skills))->map(fn ($s) => trim($s))->filter();
    $educations = collect(preg_split('/\r\n|\r|\n/', (string) $profile?->education))->map(fn ($s) => trim($s))->filter();
@endphp
<main class="wrap">
    @if(session('success'))
        <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mt-3 mb-0">Ada data yang perlu diperiksa. Silakan coba lagi.</div>
    @endif

    <section class="hero" id="profil">
        <div>
            <span class="status"><span class="pulse"></span> Terbuka untuk kolaborasi</span>
            <h1 class="hero-name">{{ $nameParts[0] }}<br>{{ $nameParts[1] ?? '' }}</h1>
            <p class="hero-role">{{ $profile?->headline ?: 'Web developer dan mahasiswa' }}</p>
            <p class="hero-copy">Saya membangun ide menjadi produk web yang rapi dan nyaman dipakai. Di sini kamu bisa melihat karya dan eksperimen yang sedang saya kerjakan.</p>
            <div class="hero-actions">
                <a href="#karya" class="btn-accent">Lihat karya ↓</a>
                @if($profile?->email)
                    <button type="button" class="btn-soft" id="copyEmail" data-email="{{ $profile->email }}">Salin email</button>
                @endif
                <button type="button" class="btn-soft" onclick="window.print()">Simpan CV / PDF</button>
            </div>
        </div>
        <div>
            <div class="portrait">
                @if($profile?->photo_path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profile->photo_path) }}" alt="Foto {{ $displayName }}">
                @else
                    <div class="portrait-initials" aria-label="Foto profil belum ditambahkan">Reshar</div>
                @endif
                <span class="portrait-chip">{{ $profile?->address ?: 'Indonesia' }}</span>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn-soft mt-3">{{ $profile ? 'Kelola profil & foto' : 'Lengkapi profil' }}</a>
        </div>
    </section>

    <div class="facts">
        <div class="fact"><span class="fact-value">{{ $portofolios->count() }}</span><span class="fact-label">Proyek dipublikasikan</span></div>
        <div class="fact"><span class="fact-value">{{ $technologies->count() }}</span><span class="fact-label">Teknologi digunakan</span></div>
        <div class="fact"><span class="fact-value">{{ $skills->count() }}</span><span class="fact-label">Keahlian yang diasah</span></div>
    </div>

    @if($technologies->isNotEmpty())
        <div class="marquee" aria-hidden="true">
            <div class="marquee-track">
                @foreach([1, 2] as $loop2)
                    @foreach($technologies as $technology)<span>{{ $technology }}</span>@endforeach
                @endforeach
            </div>
        </div>
    @endif

    <section id="karya">
        <div class="sec-head">
            <div>
                <h2 class="sec-title">Karya pilihan</h2>
                <p class="sec-copy">Proyek yang lahir dari rasa penasaran dan proses belajar.</p>
            </div>
            <span class="text-secondary small"><span id="visibleCount">{{ $portofolios->count() }}</span> dari {{ $portofolios->count() }} proyek</span>
        </div>

        <div class="tools">
            <div class="search-wrap"><span aria-hidden="true">⌕</span><input id="projectSearch" class="form-control control search-input" type="search" placeholder="Cari proyek, deskripsi, atau teknologi" aria-label="Cari proyek"></div>
            <select id="technologyFilter" class="form-select control" aria-label="Filter teknologi" style="max-width:220px"><option value="">Semua teknologi</option>@foreach($technologies as $technology)<option value="{{ mb_strtolower($technology) }}">{{ $technology }}</option>@endforeach</select>
            <select id="projectSort" class="form-select control" aria-label="Urutkan proyek" style="max-width:190px"><option value="default">Terbaru</option><option value="title">Nama A–Z</option><option value="title-desc">Nama Z–A</option></select>
        </div>

        <div class="project-grid" id="projectGrid">
            @forelse($portofolios as $item)
                @php($itemTechnologies = collect(explode(',', $item->teknologi))->map(fn ($t) => trim($t))->filter())
                <article class="project-card" data-title="{{ mb_strtolower($item->judul) }}" data-description="{{ mb_strtolower($item->deskripsi) }}" data-technologies="{{ mb_strtolower($itemTechnologies->implode('|')) }}" data-created="{{ $item->created_at?->timestamp ?? 0 }}">
                    <a class="project-visual" href="{{ route('portofolio.show', $item) }}" aria-label="Lihat {{ $item->judul }}">
                        @if($item->gambar)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->gambar) }}" alt="Pratinjau {{ $item->judul }}" loading="lazy">
                        @else
                            <span class="project-fallback" aria-hidden="true">{{ mb_strtoupper(mb_substr($item->judul, 0, 1)) }}</span>
                        @endif
                        <span class="go" aria-hidden="true">↗</span>
                    </a>
                    <h3 class="project-title">{{ $item->judul }}</h3>
                    <p class="project-description">{{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}</p>
                    <div class="tech-tags">@foreach($itemTechnologies as $technology)<span class="tech-tag">{{ $technology }}</span>@endforeach</div>
                    <div class="project-actions">
                        <a href="{{ route('portofolio.show', $item) }}">Detail</a>
                        @if($item->link)<a href="{{ $item->link }}" target="_blank" rel="noopener noreferrer">Demo ↗</a>@endif
                        <a href="{{ route('portofolio.edit', $item) }}">Edit</a>
                        <form action="{{ route('portofolio.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">@csrf @method('DELETE')<button type="submit">Hapus</button></form>
                    </div>
                </article>
            @empty
                <div class="empty-state"><h3 class="sec-title" style="font-size:1.8rem">Ruang untuk karya pertama</h3><p class="text-secondary mt-2">Tambahkan proyek pertamamu dan mulai bangun cerita portofolio.</p><a class="btn-accent" href="{{ route('portofolio.create') }}">Tambah proyek pertama</a></div>
            @endforelse
            <div class="empty-state no-results" id="noResults"><h3 class="sec-title" style="font-size:1.8rem">Belum ada yang cocok</h3><p class="text-secondary mt-2">Coba kata kunci atau teknologi yang berbeda.</p><button type="button" class="btn-soft" id="clearFilters">Hapus filter</button></div>
        </div>
    </section>

    <section class="sec-head" style="margin-bottom:28px" id="keahlian"><div><h2 class="sec-title">Keahlian & pendidikan</h2></div></section>
    <section class="about">
        <div class="info-card"><h3 class="info-title">Keahlian</h3>
            @if($skills->isNotEmpty())
                <div class="skill-list">@foreach($skills as $skill)<span class="skill-pill">{{ $skill }}</span>@endforeach</div>
            @else
                <p class="text-secondary mb-0">Keahlian akan muncul di sini setelah profil dilengkapi.</p>
            @endif
        </div>
        <div class="info-card"><h3 class="info-title">Pendidikan</h3>
            @if($educations->isNotEmpty())
                <ul class="education-list">@foreach($educations as $education)<li>{{ $education }}</li>@endforeach</ul>
            @else
                <p class="text-secondary mb-0">Informasi pendidikan akan tampil di sini.</p>
            @endif
        </div>
    </section>

    <section class="cta" id="kontak">
        <h2>Punya ide atau proyek? Ayo ngobrol.</h2>
        <p>Saya selalu terbuka untuk belajar, berkolaborasi, dan mencoba hal baru bersama.</p>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ $githubUrl }}" class="btn-ink" target="_blank" rel="noopener noreferrer">Buka GitHub ↗</a>
            @if($profile?->email)<button type="button" class="btn-ink btn-ink-line" id="copyEmail2" data-email="{{ $profile->email }}">Salin email</button>@endif
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('projectSearch');
    const technologyFilter = document.getElementById('technologyFilter');
    const projectSort = document.getElementById('projectSort');
    const projectGrid = document.getElementById('projectGrid');
    const noResults = document.getElementById('noResults');
    const cards = [...projectGrid.querySelectorAll('.project-card')];
    const visibleCount = document.getElementById('visibleCount');

    function updateProjects() {
        const query = searchInput.value.trim().toLocaleLowerCase('id');
        const tech = technologyFilter.value;
        let shown = 0;
        cards.forEach((card) => {
            const okQuery = `${card.dataset.title} ${card.dataset.description} ${card.dataset.technologies}`.includes(query);
            const okTech = !tech || card.dataset.technologies.split('|').includes(tech);
            card.hidden = !(okQuery && okTech);
            shown += card.hidden ? 0 : 1;
        });
        const mode = projectSort.value;
        [...cards].sort((a, b) => {
            if (mode === 'title') return a.dataset.title.localeCompare(b.dataset.title, 'id');
            if (mode === 'title-desc') return b.dataset.title.localeCompare(a.dataset.title, 'id');
            return Number(b.dataset.created) - Number(a.dataset.created);
        }).forEach((card) => projectGrid.insertBefore(card, noResults));
        noResults.style.display = shown === 0 && cards.length > 0 ? 'block' : 'none';
        visibleCount.textContent = shown;
    }

    searchInput.addEventListener('input', updateProjects);
    technologyFilter.addEventListener('change', updateProjects);
    projectSort.addEventListener('change', updateProjects);
    document.getElementById('clearFilters').addEventListener('click', () => {
        searchInput.value = '';
        technologyFilter.value = '';
        projectSort.value = 'default';
        updateProjects();
    });

    ['copyEmail', 'copyEmail2'].forEach((id) => {
        const button = document.getElementById(id);
        button?.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(button.dataset.email);
                showToast('Email berhasil disalin.');
            } catch {
                window.location.href = `mailto:${button.dataset.email}`;
            }
        });
    });
</script>
@endpush
