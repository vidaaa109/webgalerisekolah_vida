@extends('layouts.app')

@section('title', 'Informasi Terkini - SMKN 4 BOGOR')

@section('content')
<style>
    .info-card {
        transition: all 0.3s ease;
        border: none;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .info-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(16, 150, 247, 0.2);
    }
</style>

<div class="container mb-5 mt-4">
    <div class="row g-4">
        @forelse($posts as $post)
        <div class="col-md-6 col-lg-4">
            <div class="card info-card shadow-sm">
                @if($post->galeries->isNotEmpty() && $post->galeries->first()->fotos->isNotEmpty())
                <img src="{{ $post->galeries->first()->fotos->first()->url }}" class="card-img-top" alt="{{ $post->judul }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body p-4">
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
