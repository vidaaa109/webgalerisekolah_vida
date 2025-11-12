@extends('layouts.admin')

@section('title', 'Detail Foto - Admin SMKN 4 BOGOR')
@section('page-title', 'Detail Foto')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Detail Foto</h5>
                    <div>
                        <a href="{{ route('admin.foto.edit', $foto) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.foto.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{ $foto->galery->post->judul }}</h3>
                            <p class="text-muted">Dibuat pada {{ $foto->created_at->format('d M Y H:i') }}</p>
                            
                            <div class="text-center mb-4">
                                <img src="{{ Storage::url($foto->file) }}" alt="{{ $foto->galery->post->judul }}" class="img-fluid rounded shadow" style="max-height: 500px;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Informasi Foto</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Galeri:</strong> {{ $foto->galery->post->judul }}</p>
                                    <p><strong>Position Galeri:</strong> {{ $foto->galery->position }}</p>
                                    <p><strong>File:</strong> {{ basename($foto->file) }}</p>
                                    <p><strong>Dibuat:</strong> {{ $foto->created_at->format('d M Y H:i') }}</p>
                                    <p><strong>Diupdate:</strong> {{ $foto->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
