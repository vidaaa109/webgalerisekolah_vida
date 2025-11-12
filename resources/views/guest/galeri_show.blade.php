@extends('layouts.app')

@section('title', 'Detail Galeri - SMKN 4 BOGOR')

@section('content')
<style>
  .back-btn-detail { display: inline-flex; align-items: center; gap: 8px; color: #0f172a; text-decoration: none; font-weight: 600; padding: 10px 20px; border-radius: 10px; background: #fff; border: 2px solid #0f172a; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 2px 4px rgba(15,23,42,.1); }
  .back-btn-detail:hover { background: #0f172a; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(15,23,42,.2); }
  .detail-carousel { padding: 20px 16px 16px 16px; }
  .detail-carousel img { border-radius: 16px; max-height: 45vh; object-fit: contain; background: #000; }
  @media (max-width: 991.98px) { 
    .detail-carousel { padding: 12px; }
    .detail-carousel img { max-height: 40vh; }
    .row.g-4 > .col-lg-7, .row.g-4 > .col-lg-5 { margin-bottom: 1.5rem; }
  }
  /* Recommendation cards */
  .recommendation-card { position: relative; border-radius: 12px; overflow: hidden; aspect-ratio: 4/3; cursor: pointer; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 12px rgba(15,23,42,.08); }
  .recommendation-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(15,23,42,.15); }
  .recommendation-card img { width: 100%; height: 100%; object-fit: cover; }
  
  /* Photo caption style (Instagram-like) */
  .photo-caption { padding: 12px 20px; background: #fafafa; border-top: 1px solid #efefef; font-size: 14px; color: #262626; }
  .photo-caption strong { font-weight: 600; }
  
  /* Carousel dots indicator */
  .carousel-indicators { position: absolute; bottom: 16px; left: 0; right: 0; z-index: 2; display: flex; justify-content: center; align-items: center; gap: 6px; margin: 0; padding: 0 10px; }
  .carousel-indicators [data-bs-target] { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.5); border: none; opacity: 1; margin: 0; padding: 0; transition: all 0.3s ease; cursor: pointer; flex-shrink: 0; }
  .carousel-indicators .active { width: 8px; height: 8px; background: #fff; transform: scale(1.2); }
  .carousel-indicators::-webkit-scrollbar { display: none; }
  .carousel-inner { border-radius: 16px; overflow: hidden; position: relative; }
</style>
<section class="py-4">
  <div class="container">
    <div class="mb-3">
      <a href="{{ route('guest.galeri') }}" class="back-btn-detail">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Galeri</span>
      </a>
    </div>
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="border shadow-sm bg-white" style="border-radius: 16px; overflow: hidden;">
          <div id="detailCarousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
              @forelse($galery->fotos as $idx => $foto)
                <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                  <img src="{{ Storage::url($foto->file) }}" class="d-block w-100" alt="{{ $galery->post->judul }}" data-title="{{ $galery->post->judul }}">
                </div>
              @empty
                <div class="p-5 text-center text-muted">Tidak ada foto</div>
              @endforelse
            </div>
            @if($galery->fotos->count() > 1)
            <div class="carousel-indicators">
              @foreach($galery->fotos as $idx => $foto)
                <button type="button" data-bs-target="#detailCarousel" data-bs-slide-to="{{ $idx }}" class="{{ $idx === 0 ? 'active' : '' }}" aria-label="Foto {{ $idx + 1 }}"></button>
              @endforeach
            </div>
            @endif
            @if($galery->fotos->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#detailCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Prev</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#detailCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
            @endif
          </div>
          <div class="photo-caption" id="photoCaption">
            <strong>{{ $galery->post->judul }}</strong>
          </div>
          <div class="p-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <form method="POST" action="{{ route('galleries.like', $galery) }}">@csrf
                <button type="submit" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                  <i class="bi bi-heart{{ auth('user')->check() && $galery->likes->where('user_id', auth('user')->id())->count() > 0 ? '-fill text-danger' : '' }}"></i>
                  <span class="small">{{ $galery->total_likes ?? $galery->likes->count() }}</span>
                </button>
              </form>
              <a href="#komentar" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-chat"></i>
                <span class="small">{{ $galery->total_comments ?? $galery->comments->count() }}</span>
              </a>
              <button type="button" id="shareBtn" class="btn btn-outline-secondary"><i class="bi bi-share"></i></button>
              @if($galery->fotos->first())
              <a class="btn btn-outline-secondary" href="{{ route('galleries.fotos.download', [$galery, $galery->fotos->first()]) }}"><i class="bi bi-download"></i></a>
              @endif
            </div>
            <form method="POST" action="{{ route('galleries.bookmark', $galery) }}">@csrf
              <button type="submit" class="btn {{ auth('user')->check() && $galery->bookmarks->where('user_id', auth('user')->id())->count() > 0 ? 'btn-danger' : 'btn-outline-danger' }}">
                <i class="bi bi-bookmark{{ auth('user')->check() && $galery->bookmarks->where('user_id', auth('user')->id())->count() > 0 ? '-fill' : '' }}"></i> Simpan
              </button>
            </form>
          </div>
          <div id="komentar" class="p-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold mb-0">Komentar ({{ $galery->total_comments ?? $galery->comments->where('parent_id', null)->count() }})</h6>
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#commentsSection" aria-expanded="true">
                <i class="bi bi-chevron-up" id="toggleIcon"></i>
              </button>
            </div>
            <div class="collapse show" id="commentsSection">
            
            @auth('user')
            <form method="POST" action="{{ route('galleries.comments.store', $galery) }}" class="mb-4">
              @csrf
              <div class="d-flex gap-2 align-items-start">
                <div class="flex-shrink-0">
                  @if(auth('user')->user()->profile_photo_path)
                    <img src="{{ asset('storage/'.auth('user')->user()->profile_photo_path) }}?v={{ auth('user')->user()->updated_at?->timestamp ?? now()->timestamp }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;" alt="">
                  @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#e2e8f0;color:#64748b;font-weight:700;">
                      {{ strtoupper(substr(auth('user')->user()->name ?? 'U',0,1)) }}
                    </div>
                  @endif
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex gap-2 align-items-end">
                    <textarea name="body" class="form-control" rows="2" placeholder="Tulis komentar..." required style="resize:none;"></textarea>
                    <button type="submit" class="btn btn-primary" style="height:fit-content;">Kirim</button>
                  </div>
                </div>
              </div>
            </form>
            @else
            <div class="alert alert-info">
              <a href="{{ route('user.login') }}" class="alert-link">Login</a> untuk memberikan komentar.
            </div>
            @endauth

            <div class="comments-list" style="max-height: 50vh; overflow-y:auto;">
              @forelse($galery->comments->where('parent_id', null)->sortByDesc('created_at') as $comment)
                <div class="comment-item mb-3 pb-3 border-bottom">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      @if($comment->user?->profile_photo_path)
                        <img src="{{ asset('storage/'.$comment->user->profile_photo_path) }}?v={{ $comment->user->updated_at?->timestamp ?? now()->timestamp }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;" alt="">
                      @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#e2e8f0;color:#64748b;font-weight:700;font-size:14px;">
                          {{ strtoupper(substr($comment->user?->name ?? 'U',0,1)) }}
                        </div>
                      @endif
                    </div>
                    <div class="flex-grow-1">
                      <div class="fw-bold small">{{ $comment->user?->name ?? 'Pengguna' }}</div>
                      <div class="text-muted" style="font-size:12px;">{{ $comment->created_at->diffForHumans() }}</div>
                      <p class="mb-1 mt-1">{{ $comment->body }}</p>
                    </div>
                  </div>
                </div>
              @empty
                <p class="text-muted small">Belum ada komentar.</p>
              @endforelse
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="mb-3">
          <h5 class="fw-bold mb-1" style="color:#0f172a;">Galeri Lainnya</h5>
          <p class="text-muted small mb-0">Galeri yang mungkin Anda suka</p>
        </div>
        <div class="row g-3">
          @foreach($recommendations as $g)
            <div class="col-6 col-md-4 col-lg-6">
              <a href="{{ route('guest.galeri.show', $g) }}" class="recommendation-card d-block">
                <img src="{{ $g->fotos->first() ? Storage::url($g->fotos->first()->file) : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="">
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  const shareUrl = @json(route('guest.galeri.show', $galery));
  document.getElementById('shareBtn')?.addEventListener('click', async () => {
    try {
      if (navigator.share) {
        await navigator.share({ title: 'Galeri', url: shareUrl });
      } else {
        await navigator.clipboard.writeText(shareUrl);
      }
    } catch (e) {}
  });

  // Update caption saat foto berubah
  const carousel = document.getElementById('detailCarousel');
  if (carousel) {
    carousel.addEventListener('slide.bs.carousel', function (e) {
      const activeImg = e.relatedTarget.querySelector('img');
      const caption = document.getElementById('photoCaption');
      if (activeImg && caption) {
        const title = activeImg.getAttribute('data-title') || 'Foto Galeri';
        caption.innerHTML = '<strong>' + title + '</strong>';
      }
    });
  }

  // Toggle icon chevron untuk collapse komentar
  const commentsSection = document.getElementById('commentsSection');
  const toggleIcon = document.getElementById('toggleIcon');
  if (commentsSection && toggleIcon) {
    commentsSection.addEventListener('show.bs.collapse', function () {
      toggleIcon.className = 'bi bi-chevron-up';
    });
    commentsSection.addEventListener('hide.bs.collapse', function () {
      toggleIcon.className = 'bi bi-chevron-down';
    });
  }
</script>
@endpush
