@extends('layouts.petugas')

@section('title', 'Detail Post - Petugas SMKN 4 BOGOR')
@section('page-title', 'Detail Post')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Detail Post</h5>
                    <a href="{{ route('petugas.posts.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{ $post->judul }}</h3>
                            <div class="mb-3">
                                <span class="badge bg-info me-2">{{ $post->kategori->judul }}</span>
                                @if($post->kategoris->count() > 0)
                                    @foreach($post->kategoris as $kat)
                                        <span class="badge bg-secondary me-1">{{ $kat->judul }}</span>
                                    @endforeach
                                @endif
                                <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }} ms-1">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </div>
                            <div class="mt-3">
                                {!! nl2br(e($post->isi)) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Post</h6>
                                    <hr>
                                    <p class="mb-2"><strong>Kategori:</strong><br>
                                        <span class="badge bg-info">{{ $post->kategori->judul }}</span>
                                    </p>
                                    <p class="mb-2"><strong>Petugas:</strong><br>
                                        {{ $post->petugas->username }}
                                    </p>
                                    <p class="mb-2"><strong>Status:</strong><br>
                                        <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </p>
                                    <p class="mb-2"><strong>Dibuat:</strong><br>
                                        {{ $post->created_at->format('d M Y H:i') }}
                                    </p>
                                    <p class="mb-0"><strong>Diupdate:</strong><br>
                                        {{ $post->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('petugas.posts.edit', $post) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Post
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
