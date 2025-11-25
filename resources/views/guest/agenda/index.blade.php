@extends('layouts.app')

@section('title', 'Agenda - SMKN 4 BOGOR')

@section('content')
<style>
    .agenda-card {
        transition: all 0.3s ease;
        border: none;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .agenda-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(16, 150, 247, 0.2);
    }
    
    .agenda-date {
        background: linear-gradient(135deg, #0b244d 0%, #1096f7 100%);
        color: white;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-right: 1rem;
        min-width: 80px;
        box-shadow: 0 2px 8px rgba(16, 150, 247, 0.3);
    }
    
    .agenda-date .day {
        font-size: 2rem;
        font-weight: bold;
        line-height: 1;
    }
    
    .agenda-date .month {
        font-size: 0.9rem;
        text-transform: uppercase;
    }
</style>

<div class="container mb-5 mt-4">
    <div class="row g-4">
        @forelse($posts as $post)
        <div class="col-md-6 col-lg-4">
            <div class="card agenda-card shadow-sm">
                @if($post->galeries->isNotEmpty() && $post->galeries->first()->fotos->isNotEmpty())
                <img src="{{ $post->galeries->first()->fotos->first()->url }}" class="card-img-top" alt="{{ $post->judul }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="agenda-date" style="min-width: 60px; padding: 0.6rem;">
                                <div class="day" style="font-size: 1.5rem;">{{ $post->created_at->format('d') }}</div>
                                <div class="month" style="font-size: 0.75rem;">{{ $post->created_at->format('M') }}</div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-1">{{ $post->judul }}</h5>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-user me-1"></i>
                                    {{ $post->petugas->username }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="card-text text-muted">{{ Str::limit(strip_tags($post->isi), 100) }}</p>
                    
                    <a href="{{ route('guest.agenda.show', $post) }}" class="btn btn-outline-primary btn-sm">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada agenda tersedia</p>
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
