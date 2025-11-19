@extends('layouts.admin')

@section('title', 'Pengguna - Admin SMKN 4 BOGOR')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Cari Pengguna</label>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau username">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="active" @selected(request('status') === 'active')>Aktif</option>
                            <option value="blocked" @selected(request('status') === 'blocked')>Diblokir</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary flex-fill" type="submit">Filter</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Pelaporan</th>
                        <th>Terdaftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                            @if($user->status === 'blocked' && $user->blocked_reason)
                                <div><small class="text-muted">{{ $user->blocked_reason }}</small></div>
                            @endif
                        </td>
                        <td>
                            @if($user->reports_received_count > 0)
                                <span class="badge bg-warning text-dark">{{ $user->reports_received_count }} laporan</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td><small>{{ $user->created_at->format('d M Y') }}</small></td>
                        <td class="text-center">
                            <form action="{{ route('admin.users.updateStatus', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $user->status === 'active' ? 'blocked' : 'active' }}">
                                @if($user->status === 'active')
                                <input type="hidden" name="blocked_reason" value="Diblokir oleh admin.">
                                @endif
                                <button class="btn btn-sm {{ $user->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}" type="submit">
                                    {{ $user->status === 'active' ? 'Blokir' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection

