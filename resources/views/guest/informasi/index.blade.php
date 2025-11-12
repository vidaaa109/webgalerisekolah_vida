@extends('layouts.app')

@section('title', 'Informasi Terkini - SMKN 4 BOGOR')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 4rem 0 3rem;
        margin-bottom: 3rem;
        color: white;
    }
    
    .info-card {
        transition: all 0.3s ease;
        border: none;
        height: 100%;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>

<div class="page-header">
    <div class="container">
        <h1 class="display-4 fw-bold mb-2">Informasi Terkini</h1>
        <p class="lead mb-0">Berita dan informasi terbaru dari SMKN 4 BOGOR</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        @forelse($posts as $post)
        <div class="col-md-6 col-lg-4">
            <div class="card info-card shadow-sm">
                @if($post->galeries->isNotEmpty() && $post->galeries->first()->fotos->isNotEmpty())
                <img src="{{ Storage::url($post->galeries->first()->fotos->first()->file) }}" class="card-img-top" alt="{{ $post->judul }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body p-4">
                    <span class="badge bg-primary mb-3">{{ $post->kategori->judul }}</span>
                    <h5 class="card-title fw-bold mb-3">{{ $post->judul }}</h5>
                    <p class="card-text text-muted">{{ Str::limit(strip_tags($post->isi), 120) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            <i class="far fa-calendar me-1"></i>
                            {{ $post->created_at->format('d M Y') }}
                        </small>
                        <a href="{{ route('guest.informasi.show', $post) }}" class="btn btn-outline-primary btn-sm">
                            Baca Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada informasi tersedia</p>
        </div>
        @endforelse
    </div>
    
    @if($posts->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection
