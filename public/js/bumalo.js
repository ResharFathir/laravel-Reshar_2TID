(function () {
  // Ganti dengan nomor WhatsApp toko (format 62..., tanpa + atau 0 di depan)
  var WA = '6281234567890';
  var KEY = 'bumalo_cart';
  var reduce = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
  var cur = 0, tt, cart = load(), sel = null;

  /* ---------- util ---------- */
  function load() { try { return JSON.parse(localStorage.getItem(KEY)) || []; } catch (e) { return []; } }
  function save() { try { localStorage.setItem(KEY, JSON.stringify(cart)); } catch (e) {} }
  function rp(n) { return 'Rp' + Number(n).toLocaleString('id-ID'); }
  function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function safe(c) { return /^#[0-9a-f]{3,8}$/i.test(c || '') ? c : '#111111'; }
  function shoeSvg(a, b) {
    return '<svg viewBox="0 0 120 70" aria-hidden="true"><path d="M8 46C8 30 20 22 34 24l14 4c10 2 18-8 30-4 18 6 34 14 34 22z" fill="' + a + '"/><path d="M40 27l6 8M50 29l6 8M60 27l6 8" stroke="' + b + '" stroke-width="3" stroke-linecap="round"/><path d="M30 38c14 2 30 0 44-8" stroke="' + b + '" stroke-width="3" fill="none" stroke-linecap="round" opacity=".7"/><path d="M6 46h108v8q0 6-8 6H14q-8 0-8-6z" fill="' + b + '"/></svg>';
  }
  function boxSvg(c) {
    return '<svg viewBox="0 0 120 70" aria-hidden="true"><rect x="28" y="8" width="64" height="54" rx="10" fill="' + c + '"/><path d="M44 8v10a16 16 0 0 0 32 0V8" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="3"/></svg>';
  }
  function toast(m) {
    var t = document.getElementById('toast'); if (!t) return;
    t.textContent = m; t.classList.add('show'); clearTimeout(tt);
    tt = setTimeout(function () { t.classList.remove('show'); }, 1800);
  }

  /* ---------- slider & carousel ---------- */
  function show(i) {
    var s = document.querySelectorAll('.slide'); if (!s.length) return;
    cur = (i + s.length) % s.length;
    s.forEach(function (e, k) { e.classList.toggle('on', k === cur); });
    document.querySelectorAll('.slider .dots button').forEach(function (e, k) { e.classList.toggle('on', k === cur); });
  }
  function carouselDots() {
    var t = document.getElementById('trk'), d = document.getElementById('cd'); if (!t || !d) return;
    var n = Math.max(1, Math.round(t.scrollWidth / t.clientWidth)), p = Math.round(t.scrollLeft / t.clientWidth);
    d.innerHTML = '';
    for (var k = 0; k < n; k++) {
      var b = document.createElement('button'); b.className = k === p ? 'on' : '';
      b.setAttribute('aria-label', 'Halaman ' + (k + 1)); b.dataset.c = k; d.appendChild(b);
    }
  }

  /* ---------- modal pilihan ---------- */
  var modal = document.createElement('div'); modal.id = 'bm'; modal.hidden = true;
  modal.innerHTML = '<div class="bm-back" data-x></div><div class="bm-box" role="dialog" aria-modal="true" aria-label="Pilih warna dan ukuran"></div>';
  var drawer = document.createElement('aside'); drawer.id = 'bd'; drawer.hidden = true;
  drawer.innerHTML = '<div class="bm-back" data-x></div><div class="bd-box" role="dialog" aria-modal="true" aria-label="Keranjang"></div>';
  document.body.appendChild(modal); document.body.appendChild(drawer);
  var mbox = modal.querySelector('.bm-box'), dbox = drawer.querySelector('.bd-box');

  function opts(d) {
    var c1 = safe(d.c1), c2 = safe(d.c2 || '#ffffff'), sizes = [], colors;
    if (d.t === 'sepatu') {
      colors = [{ n: 'Original', a: c1, b: c2 }, { n: 'Kontras', a: c2, b: c1 }, { n: 'Hitam', a: '#111111', b: '#ffffff' }, { n: 'Putih', a: '#f4f4f4', b: '#111111' }];
      var r = { pria: [39, 45], wanita: [36, 41], anak: [28, 35] }[d.g] || [36, 45];
      for (var i = r[0]; i <= r[1]; i++) sizes.push(String(i));
    } else {
      colors = [{ n: 'Original', a: c1 }, { n: 'Hitam', a: '#111111' }, { n: 'Putih', a: '#f4f4f4' }, { n: 'Abu-abu', a: '#8a8f98' }];
      if (d.grp === 'Pakaian') sizes = ['S', 'M', 'L', 'XL'];
      else if (d.grp === 'Kaos kaki') sizes = ['36–40', '41–45'];
    }
    return { colors: colors, sizes: sizes };
  }

  function renderModal() {
    var d = sel.d, o = sel.o, col = o.colors[sel.ci];
    var pic = d.t === 'sepatu' ? shoeSvg(col.a, col.b) : boxSvg(col.a);
    var h = '<button class="bm-x" data-x aria-label="Tutup">×</button><div class="bm-pic">' + pic + '</div><h3>' + esc(d.n) + '</h3><div class="price">' + rp(d.p) + '</div>';
    h += '<p class="bm-l">Warna: <b>' + col.n + '</b></p><div class="bm-sw">' + o.colors.map(function (k, i) {
      return '<button type="button" class="sw' + (i === sel.ci ? ' on' : '') + '" data-ci="' + i + '" style="background:' + k.a + '" aria-label="' + k.n + '"></button>';
    }).join('') + '</div>';
    if (o.sizes.length) {
      h += '<p class="bm-l">Ukuran' + (d.t === 'sepatu' ? ' (EU)' : '') + ': <b>' + (sel.si < 0 ? 'pilih dulu' : o.sizes[sel.si]) + '</b></p><div class="bm-sz">' + o.sizes.map(function (z, i) {
        return '<button type="button" class="sz' + (i === sel.si ? ' on' : '') + '" data-si="' + i + '">' + z + '</button>';
      }).join('') + '</div>';
    }
    h += '<div class="bm-q"><button type="button" data-q="-1" aria-label="Kurangi">−</button><span>' + sel.qty + '</span><button type="button" data-q="1" aria-label="Tambah">+</button></div><p class="bm-err" id="bm-err" role="alert"></p><button type="button" class="bm-go" data-go>Masukkan ke keranjang</button>';
    mbox.innerHTML = h;
  }

  function openModal(btn) {
    var d = btn.dataset, o = opts(d);
    sel = { d: { id: d.id, n: d.n, p: +d.p, t: d.t, g: d.g, grp: d.grp }, o: o, ci: 0, si: o.sizes.length ? -1 : 0, qty: 1 };
    renderModal(); modal.hidden = false; var x = mbox.querySelector('.bm-x'); if (x) x.focus();
  }

  function addToCart() {
    if (sel.o.sizes.length && sel.si < 0) { document.getElementById('bm-err').textContent = 'Pilih ukuran dulu.'; return; }
    var col = sel.o.colors[sel.ci], size = sel.o.sizes.length ? sel.o.sizes[sel.si] : '';
    var key = sel.d.id + '|' + col.n + '|' + size, f = cart.filter(function (x) { return x.key === key; })[0];
    if (f) f.qty += sel.qty;
    else cart.push({ key: key, name: sel.d.n, price: sel.d.p, color: col.n, hex: col.a, size: size, qty: sel.qty });
    save(); modal.hidden = true; updateCount(); renderDrawer(); drawer.hidden = false;
    toast(sel.d.n + ' masuk ke keranjang');
  }

  /* ---------- keranjang ---------- */
  function count() { return cart.reduce(function (s, x) { return s + x.qty; }, 0); }
  function updateCount() { var c = document.getElementById('cart'); if (c) c.textContent = 'Keranjang (' + count() + ')'; }

  function renderDrawer() {
    var total = cart.reduce(function (s, x) { return s + x.price * x.qty; }, 0);
    var h = '<div class="bd-head"><h3>Keranjang</h3><button type="button" class="bm-x" data-x aria-label="Tutup">×</button></div>';
    if (!cart.length) {
      h += '<div class="bd-list"><p class="bm-l">Keranjang masih kosong.</p></div>';
    } else {
      h += '<div class="bd-list">' + cart.map(function (x, i) {
        return '<div class="bd-it"><i style="background:' + safe(x.hex) + '"></i><div><b>' + esc(x.name) + '</b><br><small>' + esc(x.color) + (x.size ? ' · Ukuran ' + esc(x.size) : '') + '</small><div class="bm-q sm"><button type="button" data-dq="' + i + ',-1" aria-label="Kurangi">−</button><span>' + x.qty + '</span><button type="button" data-dq="' + i + ',1" aria-label="Tambah">+</button></div></div><div class="bd-r"><b>' + rp(x.price * x.qty) + '</b><button type="button" class="bd-del" data-rm="' + i + '">Hapus</button></div></div>';
      }).join('') + '</div>';
      var msg = 'Halo Bumalo.id, saya mau pesan:\n' + cart.map(function (x) {
        return '- ' + x.name + ' (' + x.color + (x.size ? ', ukuran ' + x.size : '') + ') x' + x.qty + ' = ' + rp(x.price * x.qty);
      }).join('\n') + '\nTotal: ' + rp(total);
      h += '<div class="bd-foot"><div class="bd-tot"><span>Total</span><b>' + rp(total) + '</b></div><a class="bd-wa" target="_blank" rel="noopener" href="https://wa.me/' + WA + '?text=' + encodeURIComponent(msg) + '">Pesan via WhatsApp</a></div>';
    }
    dbox.innerHTML = h;
  }

  /* ---------- event ---------- */
  document.addEventListener('click', function (e) {
    var T = function (s) { return e.target.closest(s); };
    var a = T('.add'), s = T('[data-s]'), d = T('[data-d]'), c = T('[data-c]');
    if (a) openModal(a);
    if (T('#cart')) { renderDrawer(); drawer.hidden = false; }
    if (T('[data-x]')) { modal.hidden = true; drawer.hidden = true; }
    var ci = T('[data-ci]'), si = T('[data-si]'), q = T('[data-q]');
    if (ci && sel) { sel.ci = +ci.dataset.ci; renderModal(); }
    if (si && sel) { sel.si = +si.dataset.si; renderModal(); }
    if (q && sel) { sel.qty = Math.max(1, sel.qty + +q.dataset.q); renderModal(); }
    if (T('[data-go]') && sel) addToCart();
    var dq = T('[data-dq]'), rm = T('[data-rm]');
    if (dq) { var p = dq.dataset.dq.split(','), it = cart[+p[0]]; it.qty += +p[1]; if (it.qty < 1) cart.splice(+p[0], 1); save(); updateCount(); renderDrawer(); }
    if (rm) { cart.splice(+rm.dataset.rm, 1); save(); updateCount(); renderDrawer(); }
    if (s) show(cur + +s.dataset.s);
    if (d) show(+d.dataset.d);
    if (c) { var t = document.getElementById('trk'); t.scrollTo({ left: c.dataset.c * t.clientWidth, behavior: reduce ? 'auto' : 'smooth' }); }
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { modal.hidden = true; drawer.hidden = true; } });

  var trk = document.getElementById('trk');
  if (trk) { var w; trk.addEventListener('scroll', function () { clearTimeout(w); w = setTimeout(carouselDots, 80); }); }
  window.addEventListener('resize', carouselDots);
  carouselDots(); updateCount();
  if (!reduce) setInterval(function () { if (!document.querySelector('.slider:hover')) show(cur + 1); }, 5500);
})();