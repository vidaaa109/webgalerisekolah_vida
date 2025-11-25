@extends('layouts.app')

@section('title', 'Galeri - SMKN 4 BOGOR')

@section('content')
    <style>
        /* Grid default: 4 desktop, 3 tablet, 2 mobile */
        .gallery-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 28px; width:100%; margin-bottom: 2rem; }
        @media (max-width: 991.98px) { .gallery-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; } }
        @media (max-width: 767.98px) { .gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; } }
        /* Link pengklik memenuhi kartu */
        .gallery-link { position:absolute; inset:0; z-index:10; display:block; cursor:pointer; }

        /* Card */
        .gallery-card { position:relative; border-radius:16px; overflow:visible; background:#fff; box-shadow: 0 4px 12px rgba(15,23,42,.08); transition: all .2s cubic-bezier(0.4, 0, 0.2, 1); isolation:isolate; cursor:pointer; }
        .gallery-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(15,23,42,.15); }
        .gallery-card-img-wrapper { position:relative; aspect-ratio:4/3; border-radius:16px; overflow:hidden; }
        .gallery-card img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; pointer-events:none; }
        .gallery-card-title { padding:12px 8px; text-align:center; }
        .gallery-card-title h6 { margin:0; font-size:14px; font-weight:600; color:#0f172a; line-height:1.4; }

        /* Overlay hover */
        .gallery-overlay { position:absolute; inset:0; display:flex; flex-direction:column; align-items:stretch; justify-content:flex-start; padding:.5rem; pointer-events:none; opacity:0; transition: opacity .35s ease; z-index:15; }
        .fade-slide { opacity:0; transform: translateY(-8px); transition: opacity .35s ease, transform .35s ease; pointer-events:none; }
        .gallery-card:hover .gallery-overlay { opacity:1; pointer-events:none; }
        .gallery-card:hover .fade-slide { opacity:1; transform: translateY(0); pointer-events:none; }
        .gallery-overlay .icon-btn { width:36px; height:36px; border-radius:999px; display:flex; align-items:center; justify-content:center; background: rgba(15,23,42,.75); color:#fff; border:1px solid rgba(255,255,255,.18); pointer-events:auto; position:relative; z-index:25; }
        .gallery-overlay .icon-btn:hover { background: rgba(15,23,42,.9); }

        /* Arrows (tampil jika >1 foto) */
        .gallery-arrow { position:absolute; top:50%; transform: translateY(-50%); width:36px; height:36px; border-radius:999px; display:none; align-items:center; justify-content:center; background: rgba(15,23,42,.6); color:#fff; border:none; z-index:25; cursor:pointer; pointer-events:auto; }
        .gallery-arrow.left { left:.5rem; }
        .gallery-arrow.right { right:.5rem; }
        .gallery-card.has-multi:hover .gallery-arrow { display:flex; }

        /* Dots di bawah foto - Perfect circles tanpa terpotong */
        .gallery-dots { 
            position:absolute; 
            left:0; 
            right:0; 
            bottom:1rem; 
            display:flex; 
            justify-content:center; 
            align-items:center; 
            pointer-events:none; 
            z-index:15; 
            padding:10px 16px;
            min-height:30px;
        }
        .gallery-dots .dots-scroll { 
            display:flex; 
            align-items:center; 
            justify-content:center;
            gap:10px; 
            max-width:160px; 
            overflow-x:auto; 
            overflow-y:visible !important; 
            scrollbar-width:none; 
            pointer-events:none; 
            padding:8px 6px;
        }
        .gallery-dots .dots-scroll::-webkit-scrollbar { display:none; }
        .gallery-dots .dot { 
            display:inline-block; 
            width:6px; 
            height:6px; 
            min-width:6px;
            min-height:6px;
            border-radius:50%; 
            background: rgba(255,255,255,.7); 
            flex-shrink:0; 
            flex-grow:0;
            transition: all .3s ease; 
            cursor:pointer; 
            pointer-events:auto;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        .gallery-dots .dot.active { 
            background:#fff; 
            width:8px;
            height:8px;
            min-width:8px;
            min-height:8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.5);
        }

        /* Header chips (tetap) */
        .cats { display:flex; flex-wrap:wrap; gap:12px; padding: 0.5rem 0; }
        .cat-chip { display:inline-flex; align-items:center; justify-content:center; padding:.6rem 1rem; background:#001f3f; color:#fff; border-radius:10px; text-decoration:none; border:2px solid #001f3f; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); font-weight:600; font-size:14px; box-shadow: 0 2px 4px rgba(0,31,63,.1); }
        .cat-chip:hover { background:#003366; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,31,63,.2); color:#fff; }
        .cat-chip.is-light { background:#fff; color:#001f3f; border-color:#001f3f; box-shadow: 0 2px 8px rgba(0,31,63,.12); }
        .cat-chip.is-light:hover { background:#001f3f; color:#fff; border-color:#001f3f; }
    </style>

    <section class="py-4">
        <div class="container">
            <div class="mb-4 text-center">
                <h2 class="h3 mb-3" style="font-weight:700; color:#0f172a;">Galeri Sekolah</h2>
                @if($filterPosts->isNotEmpty())
                    <div class="cats justify-content-center">
                        <a href="{{ request()->url() }}" class="cat-chip {{ !request('post') ? 'is-light' : '' }}">Semua Galeri</a>
                        @foreach($filterPosts as $filterPost)
                            <a href="{{ request()->fullUrlWithQuery(['post' => $filterPost->id]) }}" 
                               class="cat-chip {{ request('post') == $filterPost->id ? 'is-light' : '' }}">
                                {{ $filterPost->judul }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            @if($galeries->isEmpty())
            <div class="text-center py-5">
                <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1rem;">
                    <i class="bi bi-images"></i>
                </div>
                <h5 class="text-muted mb-2">Belum Ada Galeri</h5>
                <p class="text-muted small">Galeri akan muncul di sini ketika sudah ditambahkan</p>
            </div>
            @else
            <div class="gallery-grid">
                @foreach($galeries as $galery)
                    @php($photos = $galery->fotos->filter(fn($f) => $f->url !== null))
                    @php($first = $photos->first())
                    <div class="gallery-card {{ $photos->count() > 1 ? 'has-multi' : '' }}" id="g-{{ $galery->id }}">
                        <div class="gallery-card-img-wrapper">
                            <img src="{{ $first ? $first->url : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="{{ $galery->judul ?? $galery->post->judul }}" loading="lazy">
                            <a class="gallery-link" href="{{ route('guest.galeri.show', $galery) }}" aria-label="Buka galeri"></a>
                            <div class="gallery-overlay fade-slide">
                                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                    <a class="icon-btn" title="Unduh" id="dl-{{ $galery->id }}" href="{{ $first ? $first->url : '#' }}" download onclick="event.stopPropagation();"><i class="bi bi-download"></i></a>
                                    <button type="button" class="icon-btn" title="Simpan" onclick="return bookmarkTile(event, '{{ $galery->id }}')"><i class="bi bi-bookmark"></i></button>
                                </div>
                            </div>
                            <div class="gallery-title-overlay">
                                <div class="gallery-title-text">{{ $galery->post->judul }}</div>
                            </div>
                        </div>
                        <button type="button" class="gallery-arrow left" onclick="return cycleTile(event, '{{ $galery->id }}', -1)"><i class="bi bi-chevron-left"></i></button>
                        <button type="button" class="gallery-arrow right" onclick="return cycleTile(event, '{{ $galery->id }}', 1)"><i class="bi bi-chevron-right"></i></button>
                        <div class="gallery-dots" aria-hidden="false">
                            <div class="dots-scroll" id="dots-{{ $galery->id }}"></div>
                        </div>
                        <div class="gallery-card-title">
                            <h6>{{ $galery->judul ?? $galery->post->judul }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            {{-- Section untuk Posts dengan kategori "Galeri Sekolah" --}}
            @if($galeriPosts->isNotEmpty())
            <div class="mt-5 pt-4">
                <div class="text-center mb-4">
                    <h3 class="h4 mb-2" style="font-weight:700; color:#0f172a;">Artikel Galeri</h3>
                    <p class="text-muted small">Informasi dan artikel terkait galeri sekolah</p>
                </div>
                <div class="row g-4">
                    @foreach($galeriPosts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease;">
                            <div class="card-body p-4">
                                <span class="badge bg-primary mb-3">{{ $post->kategori->judul }}</span>
                                <h5 class="card-title fw-bold mb-3">{{ $post->judul }}</h5>
                                <p class="card-text text-muted">{{ Str::limit(strip_tags($post->isi), 100) }}</p>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ $post->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
// Dataset foto per tile dan kontrol navigasi panah / hover dengan dots
(function(){
  const photos = {};
  @foreach($galeries as $galery)
    photos[{{ $galery->id }}] = [
      @foreach($galery->fotos->filter(fn($f) => $f->url !== null) as $f)
        @json($f->url){{ !$loop->last ? ',' : '' }}
      @endforeach
    ];
  @endforeach

  const state = new Map(); // id -> {idx}

  function setImage(id, idx){
    const list = photos[id] || [];
    if (!list.length) return;
    const tile = document.getElementById('g-' + id);
    const img = tile?.querySelector('img');
    if (!img) return;
    img.src = list[idx];
    const dots = document.querySelectorAll('#dots-' + id + ' .dot');
    dots.forEach((d,i)=> d.classList.toggle('active', i === idx));
    const dl = document.getElementById('dl-' + id);
    if (dl) dl.href = list[idx];
    // scroll dots agar titik aktif tetap terlihat (centered)
    const wrap = document.querySelector('#dots-' + id);
    if (wrap && wrap.children[idx]) {
      const activeDot = wrap.children[idx];
      const wrapWidth = wrap.clientWidth;
      const dotLeft = activeDot.offsetLeft;
      const dotWidth = activeDot.clientWidth;
      const scrollLeft = dotLeft - (wrapWidth / 2) + (dotWidth / 2);
      wrap.scrollTo({ left: Math.max(0, scrollLeft), behavior: 'smooth' });
    }
    state.set(id, { idx });
  }

  window.bookmarkTile = function(ev, id){
    if (ev) { ev.preventDefault(); ev.stopPropagation(); }
    const btn = ev.currentTarget;
    btn.classList.toggle('active');
    btn.innerHTML = btn.classList.contains('active') ? '<i class="bi bi-bookmark-fill"></i>' : '<i class="bi bi-bookmark"></i>';
    return false;
  }

  window.cycleTile = function(ev, id, step){
    if (ev) { ev.preventDefault(); ev.stopPropagation(); }
    const list = photos[id] || [];
    if (!list.length) return false;
    const cur = state.get(id)?.idx || 0;
    const next = (cur + step + list.length) % list.length;
    setImage(id, next);
    return false;
  }

  document.querySelectorAll('.gallery-card').forEach(tile => {
    const id = parseInt(tile.id.replace('g-',''));
    const list = photos[id] || [];
    if (!list.length) return;
    // build dots sesuai jumlah foto
    const dotsWrap = document.getElementById('dots-' + id);
    if (dotsWrap) {
      dotsWrap.innerHTML = '';
      list.forEach((_, i) => {
        const d = document.createElement('span');
        d.className = 'dot' + (i === 0 ? ' active' : '');
        d.addEventListener('click', (e)=> { e.stopPropagation(); setImage(id, i); });
        dotsWrap.appendChild(d);
      });
      // sembunyikan dots jika hanya 1
      const dotsContainer = dotsWrap.closest('.gallery-dots');
      if (dotsContainer) dotsContainer.style.display = list.length > 1 ? 'flex' : 'none';
    }
    // tampilkan arrows hanya jika >1
    tile.classList.toggle('has-multi', list.length > 1);
    setImage(id, 0);

    // Swipe support (touch)
    let tsX = 0, tsY = 0, swiping = false;
    tile.addEventListener('touchstart', (e)=>{
      if (!list || list.length < 2) return;
      const t = e.changedTouches[0]; tsX = t.clientX; tsY = t.clientY; swiping = false;
    }, {passive:true});
    tile.addEventListener('touchmove', (e)=>{
      if (!list || list.length < 2) return;
      const t = e.changedTouches[0];
      const dx = t.clientX - tsX; const dy = t.clientY - tsY;
      if (Math.abs(dx) > 12 && Math.abs(dx) > Math.abs(dy)) { swiping = true; }
    }, {passive:true});
    tile.addEventListener('touchend', (e)=>{
      if (!list || list.length < 2) return;
      const t = e.changedTouches[0];
      const dx = t.clientX - tsX; const dy = t.clientY - tsY;
      if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
        e.preventDefault(); e.stopPropagation();
        const step = dx < 0 ? 1 : -1;
        const cur = state.get(id)?.idx || 0;
        const next = (cur + step + list.length) % list.length;
        setImage(id, next);
      }
      swiping = false;
    }, {passive:false});

    // Prevent following the link if it was a swipe gesture
    const link = tile.querySelector('.gallery-link');
    if (link) {
      link.addEventListener('click', (e)=>{ if (swiping) { e.preventDefault(); e.stopPropagation(); } });
    }
  });

})();
</script>
@endpush
