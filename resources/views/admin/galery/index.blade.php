@extends('layouts.admin')

@section('title', 'Galeri - Admin SMKN 4 BOGOR')
@section('page-title', 'Galeri')

@push('styles')
<style>
    .table thead th {
        background: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }
    .table tbody tr {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .table tbody tr:hover {
        background: #f8f9fa;
        transform: translateX(4px);
        box-shadow: -4px 0 0 #0d6efd, 0 2px 8px rgba(0,0,0,0.08);
    }
    .badge {
        font-weight: 500;
        padding: 6px 12px;
        min-width: 50px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
    }
    .badge i {
        font-size: 12px;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Daftar Galeri</h5>
                        <p class="text-muted small mb-0">Kelola galeri foto sekolah</p>
                    </div>
                    <a href="{{ route('admin.galery.create') }}" class="btn btn-primary" style="box-shadow: 0 2px 8px rgba(13,110,253,.25);">
                        <i class="fas fa-plus me-2"></i>Tambah Galeri
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Post</th>
                                    <th>Position</th>
                                    <th>Foto</th>
                                    <th class="text-center"><i class="bi bi-heart-fill text-danger"></i> Like</th>
                                    <th class="text-center"><i class="bi bi-chat-fill text-primary"></i> Komen</th>
                                    <th class="text-center"><i class="bi bi-bookmark-fill text-warning"></i> Simpan</th>
                                    <th class="text-center"><i class="bi bi-download text-success"></i> Unduh</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galeries as $index => $galery)
                                <tr>
                                    <td>{{ $galeries->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $galery->judul ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $galery->post->judul }}</div>
                                        <small class="text-muted">{{ Str::limit($galery->post->isi, 50) }}</small>
                                    </td>
                                    <td>{{ $galery->position }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $galery->fotos->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border" style="font-size:13px;">
                                            <i class="bi bi-heart-fill text-danger"></i> {{ $galery->total_likes ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border" style="font-size:13px;">
                                            <i class="bi bi-chat-fill text-primary"></i> {{ $galery->total_comments ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border" style="font-size:13px;">
                                            <i class="bi bi-bookmark-fill text-warning"></i> {{ $galery->total_bookmarks ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border" style="font-size:13px;">
                                            <i class="bi bi-download text-success"></i> {{ $galery->total_downloads ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ (int)$galery->status === 1 ? 'success' : 'secondary' }}">
                                            {{ (int)$galery->status === 1 ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td><small>{{ $galery->created_at->format('d M Y') }}</small></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.galery.interactions', $galery) }}" class="btn btn-sm btn-secondary" title="Laporan Interaksi">
                                                <i class="bi bi-graph-up"></i>
                                            </a>
                                            <a href="{{ route('admin.galery.show', $galery) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.galery.edit', $galery) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.galery.destroy', $galery) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Yakin ingin menghapus galeri ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size:3rem;color:#ddd;"></i>
                                        <p class="text-muted mt-2 mb-0">Belum ada galeri</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $galeries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
