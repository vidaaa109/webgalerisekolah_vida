@extends('layouts.app')

@section('title', 'Detail Galeri - SMKN 4 BOGOR')

@section('content')
<style>
  .back-btn-detail { display: inline-flex; align-items: center; gap: 8px; color: #001f3f; text-decoration: none; font-weight: 600; padding: 10px 20px; border-radius: 10px; background: #fff; border: 2px solid #001f3f; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 2px 4px rgba(0,31,63,.1); }
  .back-btn-detail:hover { background: #001f3f; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,31,63,.2); }
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
  @php
    $visibleRootComments = $galery->comments->where('status', 'visible')->where('parent_id', null);
  @endphp
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
              @forelse($galery->fotos->filter(fn($f) => $f->url !== null) as $idx => $foto)
                <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                  <img src="{{ $foto->url }}" class="d-block w-100" alt="{{ $galery->judul ?? $galery->post->judul }}" data-title="{{ $galery->judul ?? $galery->post->judul }}">
                </div>
              @empty
                <div class="p-5 text-center text-muted">Tidak ada foto</div>
              @endforelse
            </div>
            @php($availableFotos = $galery->fotos->filter(fn($f) => $f->url !== null))
            @if($availableFotos->count() > 1)
            <div class="carousel-indicators">
              @foreach($availableFotos as $idx => $foto)
                <button type="button" data-bs-target="#detailCarousel" data-bs-slide-to="{{ $idx }}" class="{{ $idx === 0 ? 'active' : '' }}" aria-label="Foto {{ $idx + 1 }}"></button>
              @endforeach
            </div>
            @endif
            @if($availableFotos->count() > 1)
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
            <strong>{{ $galery->judul ?? $galery->post->judul }}</strong>
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
                <span class="small" id="commentBadgeCount">{{ $visibleRootComments->count() }}</span>
              </a>
              <button type="button" id="shareBtn" class="btn btn-outline-secondary"><i class="bi bi-share"></i></button>
              @if($availableFotos->first())
              <a class="btn btn-outline-secondary" href="{{ route('galleries.fotos.download', [$galery, $availableFotos->first()]) }}"><i class="bi bi-download"></i></a>
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
              <h6 class="fw-bold mb-0">Komentar (<span id="commentCount">{{ $visibleRootComments->count() }}</span>)</h6>
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#commentsSection" aria-expanded="true">
                <i class="bi bi-chevron-up" id="toggleIcon"></i>
              </button>
            </div>
            <div class="collapse show" id="commentsSection">
            
            @auth('user')
            <form method="POST" action="{{ route('galleries.comments.store', $galery) }}" class="mb-4" id="commentForm">
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
            <div id="commentAlert" class="mb-3"></div>
            @else
            <div class="alert alert-info">
              <a href="{{ route('user.login') }}" class="alert-link">Login</a> untuk memberikan komentar.
            </div>
            @endauth

            <div class="comments-list" style="max-height: 50vh; overflow-y:auto;" id="commentsList">
              @forelse($visibleRootComments->sortByDesc('created_at') as $comment)
                @include('guest.partials.comment_item', ['comment' => $comment])
              @empty
                <p class="text-muted small" id="emptyComments">Belum ada komentar.</p>
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
            @php($recFirst = $g->fotos->filter(fn($f) => $f->url !== null)->first())
            <div class="col-6 col-md-4 col-lg-6">
              <a href="{{ route('guest.galeri.show', $g) }}" class="recommendation-card d-block">
                <img src="{{ $recFirst ? $recFirst->url : 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="">
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

  // Ajax submit comment
  const commentForm = document.getElementById('commentForm');
  if (commentForm) {
    const commentAlert = document.getElementById('commentAlert');
    const commentsList = document.getElementById('commentsList');
    const commentCount = document.getElementById('commentCount');
    const commentBadge = document.getElementById('commentBadgeCount');
    let emptyState = document.getElementById('emptyComments');

    const showAlert = (type, message) => {
      if (!commentAlert) return;
      commentAlert.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show mb-0" role="alert">
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      `;
    };

    const updateCounts = (value) => {
      if (commentCount) commentCount.textContent = value;
      if (commentBadge) commentBadge.textContent = value;
    };

    commentForm.addEventListener('submit', async (event) => {
      event.preventDefault();
      const submitBtn = commentForm.querySelector('button[type="submit"]');
      const originalLabel = submitBtn?.innerHTML;

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Mengirim...';
      }

      try {
        const response = await fetch(commentForm.action, {
          method: 'POST',
          body: new FormData(commentForm),
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
        });

        const data = await response.json();

        if (!response.ok) {
          const errors = data?.errors ? Object.values(data.errors).flat().join('<br>') : (data?.message || 'Terjadi kesalahan saat mengirim komentar.');
          showAlert('danger', errors);
          return;
        }

        showAlert(
          data.status === 'visible' ? 'success' : 'warning',
          data.message || (data.status === 'visible'
            ? 'Komentar berhasil ditambahkan.'
            : 'Komentar mengandung kata yang dibatasi dan menunggu peninjauan admin.')
        );

        if (data.status === 'visible' && data.html && commentsList) {
          if (emptyState) {
            emptyState.remove();
            emptyState = null;
          }
          commentsList.insertAdjacentHTML('afterbegin', data.html);
          updateCounts(data.visible_count ?? (parseInt(commentCount?.textContent || '0', 10) + 1));
          commentForm.reset();
        }
      } catch (error) {
        showAlert('danger', 'Tidak dapat mengirim komentar. Silakan coba lagi.');
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalLabel || 'Kirim';
        }
      }
    });
  }
</script>
@endpush
