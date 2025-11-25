@extends('layouts.admin')

@section('title', 'Laporan Interaksi - ' . ($galery->judul ?? $galery->post->judul))
@section('page-title', 'Laporan Interaksi Galeri')

@push('styles')
<style>
    .stat-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .table thead th {
        white-space: nowrap;
    }
    .status-badge {
        text-transform: capitalize;
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">{{ $galery->judul ?? $galery->post->judul }}</h5>
            <p class="text-muted mb-0">Post: {{ $galery->post->judul }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.galery.interactions.pdf', $galery) }}" class="btn btn-danger">
                <i class="bi bi-file-pdf me-1"></i> Cetak PDF
            </a>
            <a href="{{ route('admin.galery.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Galeri
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Like</p>
                        <h3 class="fw-bold mb-0">{{ $summary['likes'] }}</h3>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Komentar</p>
                        <h3 class="fw-bold mb-0">{{ $summary['comments'] }}</h3>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Disimpan</p>
                        <h3 class="fw-bold mb-0">{{ $summary['bookmarks'] }}</h3>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-bookmark-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pengguna Unik</p>
                        <h3 class="fw-bold mb-0">{{ $summary['unique_users'] }}</h3>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Pengguna yang Berinteraksi</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Like</th>
                        <th class="text-center">Komentar</th>
                        <th class="text-center">Simpan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interactingUsers as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">{{ $likes->where('user.id', $user->id)->count() }}</td>
                        <td class="text-center">{{ $comments->where('user.id', $user->id)->count() }}</td>
                        <td class="text-center">{{ $bookmarks->where('user.id', $user->id)->count() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada interaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Riwayat Like</h5>
                <span class="badge bg-light text-dark border">{{ $likes->count() }} data</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($likes as $like)
                            <tr>
                                <td>{{ $like->user->name ?? 'Pengguna' }}</td>
                                <td><small class="text-muted">{{ $like->created_at->diffForHumans() }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">Belum ada like.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Riwayat Simpan</h5>
                <span class="badge bg-light text-dark border">{{ $bookmarks->count() }} data</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookmarks as $bookmark)
                            <tr>
                                <td>{{ $bookmark->user->name ?? 'Pengguna' }}</td>
                                <td><small class="text-muted">{{ $bookmark->created_at->diffForHumans() }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">Belum ada data simpan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Komentar</h5>
        <span class="badge bg-light text-dark border">{{ $comments->count() }} komentar</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Komentar</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $comment->user->name ?? 'Pengguna' }}</div>
                            <small class="text-muted">{{ $comment->user->email ?? '-' }}</small>
                        </td>
                        <td>
                            {{ Str::limit($comment->body, 120) }}
                            @if($comment->moderation_note)
                                <div><small class="text-muted">{{ $comment->moderation_note }}</small></div>
                            @endif
                        </td>
                        <td>
                            <span class="badge status-badge bg-{{ $comment->status === 'visible' ? 'success' : ($comment->status === 'draft' ? 'warning' : 'secondary') }}">
                                {{ $comment->status }}
                            </span>
                        </td>
                        <td><small class="text-muted">{{ $comment->created_at->format('d M Y H:i') }}</small></td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <form action="{{ route('admin.comments.updateStatus', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $comment->status === 'visible' ? 'draft' : 'visible' }}">
                                    <button class="btn btn-sm btn-outline-primary" type="submit">
                                        {{ $comment->status === 'visible' ? 'Jadikan Draft' : 'Tayangkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada komentar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

