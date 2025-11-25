@extends('layouts.app')

@section('title', $post->judul . ' - Informasi SMKN 4 BOGOR')

@section('content')
<style>
    .back-btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #001f3f;
        text-decoration: none;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        background: #fff;
        border: 2px solid #001f3f;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0,31,63,.1);
    }

    .back-btn-detail:hover {
        background: #001f3f;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,31,63,.2);
    }

    .informasi-header {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 16px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
    }

    .informasi-date-badge {
        background: linear-gradient(135deg, #001f3f 0%, #003366 100%);
        color: white;
        padding: 1.5rem 1.25rem;
        border-radius: 16px;
        text-align: center;
        min-width: 90px;
        box-shadow: 0 4px 12px rgba(0,31,63,.15);
        margin-right: 1.5rem;
    }

    .informasi-date-badge .day {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .informasi-date-badge .month {
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.95;
    }

    .content-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(15,23,42,0.06);
        border: 1px solid #f1f5f9;
    }

    .content {
        line-height: 1.9;
        color: #475569;
        font-size: 1rem;
    }

    .content p {
        margin-bottom: 1.25rem;
    }

    .content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .content h2,
    .content h3,
    .content h4 {
        color: #001f3f;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .content ul,
    .content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .content a {
        color: #001f3f;
        text-decoration: none;
        font-weight: 500;
    }

    .content a:hover {
        text-decoration: underline;
    }

    .gallery-section {
        margin-bottom: 2rem;
    }

    .gallery-title {
        color: #001f3f;
        font-weight: 600;
        font-size: 1.125rem;
        margin-bottom: 1rem;
    }

    .carousel-item img {
        border-radius: 12px;
        max-height: 500px;
        object-fit: cover;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(0,31,63,0.8);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.9;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        background: rgba(0,31,63,0.95);
    }

    .carousel-control-prev {
        left: 20px;
    }

    .carousel-control-next {
        right: 20px;
    }

    @media (max-width: 768px) {
        .informasi-header {
            padding: 1.5rem;
        }

        .informasi-date-badge {
            min-width: 70px;
            padding: 1rem 0.75rem;
            margin-right: 1rem;
        }

        .informasi-date-badge .day {
            font-size: 2rem;
        }

        .content-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="container mb-5 mt-4">
    <div class="mb-4">
        <a href="{{ route('guest.informasi') }}" class="back-btn-detail">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Informasi</span>
        </a>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <!-- Header Section -->
            <div class="informasi-header">
                <div class="d-flex align-items-start flex-wrap">
                    <div class="informasi-date-badge">
                        <div class="day">{{ $post->created_at->format('d') }}</div>
                        <div class="month">{{ $post->created_at->format('M') }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <span class="badge bg-primary mb-3" style="font-size: 0.875rem; padding: 0.5rem 1rem;">{{ $post->kategori->judul }}</span>
                        <h1 class="fw-bold mb-3" style="color: #001f3f; font-size: 2rem; line-height: 1.2;">{{ $post->judul }}</h1>
                        <div class="d-flex align-items-center gap-3 flex-wrap text-muted">
                            <div>
                                <i class="far fa-calendar me-2"></i>
                                <span>{{ $post->created_at->format('d F Y') }}</span>
                            </div>
                            <div>
                                <i class="far fa-user me-2"></i>
                                <span>{{ $post->petugas->username }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Card -->
            <div class="content-card">
                @if($post->galeries->isNotEmpty())
                <div class="gallery-section">
                    @foreach($post->galeries as $galeryIndex => $galery)
                        @php($availableFotos = $galery->fotos->filter(fn($f) => $f->url !== null))
                        @if($availableFotos->isNotEmpty())
                        <div class="mb-5 {{ $galeryIndex > 0 ? 'mt-5' : '' }}">
                            @if($post->galeries->count() > 1)
                            <h5 class="gallery-title">{{ $galery->judul ?? 'Galeri ' . ($galeryIndex + 1) }}</h5>
                            @endif
                            <div id="informasiCarousel{{ $galeryIndex }}" class="carousel slide" data-bs-ride="false">
                                <div class="carousel-inner" style="border-radius: 12px; overflow: hidden;">
                                    @foreach($availableFotos as $idx => $foto)
                                    <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                                        <img src="{{ $foto->url }}" class="d-block w-100" alt="{{ $post->judul }}">
                                    </div>
                                    @endforeach
                                </div>
                                @if($availableFotos->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#informasiCarousel{{ $galeryIndex }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#informasiCarousel{{ $galeryIndex }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif
                
                <div class="content">
                    {!! nl2br(e($post->isi)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
