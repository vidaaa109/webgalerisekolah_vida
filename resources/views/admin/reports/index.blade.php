@extends('layouts.admin')

@section('title', 'Laporan Pengguna')
@section('page-title', 'Laporan Interaksi Pengguna')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Laporan</label>
                        <select name="type" class="form-select">
                            <option value="">Semua</option>
                            <option value="user" @selected(request('type') === 'user')>Pengguna</option>
                            <option value="comment" @selected(request('type') === 'comment')>Komentar</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="reviewed" @selected(request('status') === 'reviewed')>Ditinjau</option>
                            <option value="action_taken" @selected(request('status') === 'action_taken')>Sudah Tindakan</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2 align-items-end">
                        <button class="btn btn-primary flex-fill" type="submit">Filter</button>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Export Laporan Per Tabel</h5>
            <p class="text-muted mb-0">Unduh data galeri, like, komentar, simpan, atau pengguna dalam format CSV.</p>
        </div>
        <a href="{{ route('admin.reports.export.form') }}" class="btn btn-outline-primary">
            <i class="bi bi-download me-1"></i> Buka Halaman Export
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Pelapor</th>
                        <th>Target</th>
                        <th>Jenis</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $report->reporter->name ?? 'Pengguna' }}</div>
                            <small class="text-muted">{{ $report->reporter->email ?? '-' }}</small>
                        </td>
                        <td>
                            @if($report->type === 'user')
                                <span class="badge bg-info">User</span>
                                <div>{{ optional($report->reportable)->name ?? 'Pengguna dihapus' }}</div>
                            @else
                                <span class="badge bg-primary">Komentar</span>
                                <div>{{ Str::limit(optional($report->reportable)->body, 60) }}</div>
                            @endif
                        </td>
                        <td>{{ ucfirst($report->type) }}</td>
                        <td>{{ Str::limit($report->reason, 80) }}</td>
                        <td>
                            <span class="badge bg-{{ $report->status === 'pending' ? 'warning' : ($report->status === 'reviewed' ? 'info' : 'success') }}">
                                {{ str_replace('_', ' ', ucfirst($report->status)) }}
                            </span>
                            @if($report->admin_note)
                                <div><small class="text-muted">{{ $report->admin_note }}</small></div>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $report->created_at->diffForHumans() }}</small></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportModal{{ $report->id }}">
                                Tindak
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="reportModal{{ $report->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tindak Laporan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-1"><strong>Pelapor:</strong> {{ $report->reporter->name ?? 'Pengguna' }}</p>
                                    <p class="mb-1"><strong>Jenis:</strong> {{ ucfirst($report->type) }}</p>
                                    <p class="mb-3"><strong>Alasan:</strong> {{ $report->reason }}</p>
                                    <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="pending" @selected($report->status === 'pending')>Pending</option>
                                                <option value="reviewed" @selected($report->status === 'reviewed')>Ditinjau</option>
                                                <option value="action_taken" @selected($report->status === 'action_taken')>Sudah Tindakan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Catatan Admin</label>
                                            <textarea name="admin_note" class="form-control" rows="3">{{ old('admin_note', $report->admin_note) }}</textarea>
                                        </div>
                                        <div class="d-grid">
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-center">
        {{ $reports->links() }}
    </div>
</div>
@endsection

