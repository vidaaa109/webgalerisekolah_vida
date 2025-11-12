@extends('layouts.app')

@section('title', $post->judul . ' - Informasi SMKN 4 BOGOR')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 4rem 0 3rem;
        margin-bottom: 3rem;
        color: white;
    }
    
    .content-card {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .related-card {
        transition: all 0.3s ease;
        border: none;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>

<div class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guest.informasi') }}" class="text-white">Informasi</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="content-card mb-4">
                <div class="mb-4">
                    <span class="badge bg-primary mb-2">{{ $post->kategori->judul }}</span>
                    <h1 class="fw-bold mb-3">{{ $post->judul }}</h1>
                    <div class="text-muted">
                        <i class="far fa-calendar me-2"></i>{{ $post->created_at->format('d F Y') }}
                        <span class="mx-2">•</span>
                        <i class="far fa-user me-2"></i>{{ $post->petugas->username }}
                    </div>
                </div>
                
                @if($post->galeries->isNotEmpty() && $post->galeries->first()->fotos->isNotEmpty())
                <div class="mb-4">
                    <div id="informasiCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner" style="border-radius: 12px; overflow: hidden;">
                            @foreach($post->galeries->first()->fotos as $idx => $foto)
                            <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                                <img src="{{ Storage::url($foto->file) }}" class="d-block w-100" alt="{{ $post->judul }}" style="max-height: 400px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        @if($post->galeries->first()->fotos->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#informasiCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#informasiCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        @endif
                    </div>
                </div>
                @endif
                
                <hr class="my-4">
                
                <div class="content">
                    {!! nl2br(e($post->isi)) !!}
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ route('guest.informasi') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Informasi Terkait</h5>
                    
                    @forelse($relatedPosts as $related)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-2">
                            <a href="{{ route('guest.informasi.show', $related) }}" class="text-decoration-none text-dark">
                                {{ $related->judul }}
                            </a>
                        </h6>
                        <small class="text-muted">
                            <i class="far fa-calendar me-1"></i>
                            {{ $related->created_at->format('d M Y') }}
                        </small>
                    </div>
                    @empty
                    <p class="text-muted small mb-0">Tidak ada informasi terkait</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
