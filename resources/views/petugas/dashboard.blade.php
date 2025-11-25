@extends('layouts.petugas')

@section('title', 'Dashboard - Petugas SMKN 4 BOGOR')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Statistics Cards -->
    <div class="row g-3 g-md-4 mb-3 mb-md-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-newspaper fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-1">Total Posts</h6>
                            <h3 class="mb-0">{{ $totalPosts }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-images fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-1">Total Galeri</h6>
                            <h3 class="mb-0">{{ $totalGaleries }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-camera fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-1">Total Foto</h6>
                            <h3 class="mb-0">{{ $totalFotos }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Summary & Recent Posts -->
    <div class="row g-3 g-md-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Ringkasan Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Judul Kategori</th>
                                    <th class="text-end">Jumlah Posts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $kategori)
                                <tr>
                                    <td>{{ $kategori->judul }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-primary">
                                            {{ $kategori->posts_count + ($kategori->posts_many_to_many_count ?? 0) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Belum ada kategori</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if($kategoris->count() === 10)
                            <small class="text-muted d-block mt-2">Menampilkan 10 kategori terbaru.</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Posts Terbaru</h5>
                    <a href="{{ route('petugas.posts.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th class="d-none d-md-table-cell">Kategori</th>
                                    <th class="d-none d-lg-table-cell">Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPosts as $post)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2 d-none d-sm-flex" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fas fa-newspaper text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($post->judul, 50) }}</h6>
                                                <small class="text-muted d-md-none">{{ $post->kategori->judul }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $post->kategori->judul }}</td>
                                    <td class="d-none d-lg-table-cell">
                                        <small>{{ $post->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada posts tersedia</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 g-md-4 mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2 g-md-3">
                        <div class="col-md-4">
                            <a href="{{ route('petugas.posts.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-newspaper me-2"></i>Kelola Post
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('petugas.galery.index') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-images me-2"></i>Kelola Galeri
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('petugas.foto.index') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-camera me-2"></i>Kelola Foto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
