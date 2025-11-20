@extends('layouts.petugas')

@section('title', 'Foto - Petugas SMKN 4 BOGOR')
@section('page-title', 'Foto')

@php
use Illuminate\Support\Facades\Storage;
@endphp
@push('styles')
<style>
    .foto-card {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .foto-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.12);
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Daftar Foto</h5>
                        <p class="text-muted small mb-0">Kelola foto dalam galeri</p>
                    </div>
                    <a href="{{ route('petugas.foto.create') }}" class="btn btn-primary" style="box-shadow: 0 2px 8px rgba(13,110,253,.25);">
                        <i class="fas fa-plus me-2"></i>Upload Foto
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        @forelse($fotos as $foto)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 foto-card">
                                @if($foto->file)
                                    @php
                                        // Check if file is stored using Storage (path contains 'fotos/') or public path
                                        $imageUrl = str_contains($foto->file, 'fotos/') 
                                            ? Storage::url($foto->file) 
                                            : asset('images/gallery/' . $foto->file);
                                    @endphp
                                    <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $foto->judul ?? 'Foto' }}" style="height: 200px; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'bg-secondary d-flex align-items-center justify-content-center\' style=\'height: 200px;\'><i class=\'fas fa-image fa-3x text-white opacity-50\'></i></div>';">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-white opacity-50"></i>
                                    </div>
                                @endif
                                <div class="card-body p-3 d-flex flex-column">
                                    <p class="card-text mb-3">
                                        <small class="text-muted">
                                            {{ optional(optional($foto->galery)->post)->judul ? Str::limit($foto->galery->post->judul, 25) : 'Galeri tidak tersedia' }}
                                        </small>
                                    </p>
                                    <div class="mt-auto btn-group w-100" role="group">
                                        <a href="{{ route('petugas.foto.show', $foto) }}" class="btn btn-sm btn-info" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('petugas.foto.edit', $foto) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('petugas.foto.destroy', $foto) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <div style="font-size: 3rem; color: #e2e8f0; margin-bottom: 1rem;">
                                <i class="fas fa-images"></i>
                            </div>
                            <h6 class="text-muted mb-2">Belum Ada Foto</h6>
                            <p class="text-muted small mb-3">Klik tombol "Upload Foto" untuk menambahkan foto ke galeri</p>
                            <a href="{{ route('petugas.foto.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Upload Foto
                            </a>
                        </div>
                        @endforelse
                    </div>

                    @if($fotos->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $fotos->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
