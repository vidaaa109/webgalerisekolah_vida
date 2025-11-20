@extends('layouts.petugas')

@section('title', 'Detail Galeri - Petugas SMKN 4 BOGOR')
@section('page-title', 'Detail Galeri')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Detail Galeri</h5>
                    <a href="{{ route('petugas.galery.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Galeri</h6>
                                    <hr>
                                    <p class="mb-2"><strong>Post:</strong><br>
                                        {{ $galery->post->judul }}
                                    </p>
                                    <p class="mb-2"><strong>Position:</strong><br>
                                        {{ $galery->position }}
                                    </p>
                                    <p class="mb-2"><strong>Status:</strong><br>
                                        <span class="badge bg-{{ (int)$galery->status === 1 ? 'success' : 'secondary' }}">
                                            {{ (int)$galery->status === 1 ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </p>
                                    <p class="mb-2"><strong>Total Foto:</strong><br>
                                        {{ $galery->fotos->count() }} foto
                                    </p>
                                    <p class="mb-0"><strong>Dibuat:</strong><br>
                                        {{ $galery->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('petugas.galery.edit', $galery) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Galeri
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6>Foto dalam Galeri ini</h6>
                            <hr>
                            <div class="row g-3">
                                @forelse($galery->fotos as $foto)
                                <div class="col-sm-6 col-md-4">
                                    <div class="card">
                                        @if($foto->file)
                                            @php
                                                // Check if file is stored using Storage (path contains 'fotos/') or public path
                                                $imageUrl = str_contains($foto->file, 'fotos/') 
                                                    ? Storage::url($foto->file) 
                                                    : asset('images/gallery/' . $foto->file);
                                            @endphp
                                            <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $foto->judul ?? 'Foto' }}" style="height: 150px; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'bg-secondary d-flex align-items-center justify-content-center\' style=\'height: 150px;\'><i class=\'fas fa-image fa-2x text-white opacity-50\'></i></div>';">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 150px;">
                                                <i class="fas fa-image fa-2x text-white opacity-50"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <p class="text-muted text-center">Belum ada foto dalam galeri ini</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
