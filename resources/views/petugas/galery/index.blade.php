@extends('layouts.petugas')

@section('title', 'Galeri - Petugas SMKN 4 BOGOR')
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
    .action-btn-group .btn {
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
                    <a href="{{ route('petugas.galery.create') }}" class="btn btn-primary" style="box-shadow: 0 2px 8px rgba(13,110,253,.25);">
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
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 40%;">Judul Galeri (Post)</th>
                                    <th class="text-center d-none d-md-table-cell" style="width: 10%;">Posisi</th>
                                    <th class="text-center" style="width: 10%;">Jumlah Foto</th>
                                    <th class="text-center d-none d-lg-table-cell" style="width: 10%;">Status</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galeries as $index => $galery)
                                <tr>
                                    <td class="fw-semibold">{{ $galeries->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $galery->post->judul }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i>{{ $galery->post->kategori->judul }}
                                        </small>
                                        <div class="d-lg-none mt-1">
                                            <span class="badge bg-{{ (int)$galery->status === 1 ? 'success' : 'secondary' }} badge-sm">
                                                {{ (int)$galery->status === 1 ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <span class="badge bg-info">{{ $galery->position }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">
                                            <i class="fas fa-images me-1"></i>{{ $galery->fotos->count() }}
                                        </span>
                                    </td>
                                    <td class="text-center d-none d-lg-table-cell">
                                        <span class="badge bg-{{ (int)$galery->status === 1 ? 'success' : 'secondary' }}">
                                            <i class="fas fa-{{ (int)$galery->status === 1 ? 'check-circle' : 'times-circle' }} me-1"></i>
                                            {{ (int)$galery->status === 1 ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group action-btn-group" role="group">
                                            <a href="{{ route('petugas.galery.show', $galery) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('petugas.galery.edit', $galery) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('petugas.galery.destroy', $galery) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus galeri ini? Semua foto di dalamnya juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div style="font-size: 3rem; color: #e2e8f0; margin-bottom: 1rem;">
                                            <i class="fas fa-images"></i>
                                        </div>
                                        <h6 class="text-muted mb-2">Belum Ada Galeri</h6>
                                        <p class="text-muted small mb-3">Klik tombol "Tambah Galeri" untuk membuat galeri baru</p>
                                        <a href="{{ route('petugas.galery.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Tambah Galeri
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $galeries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
