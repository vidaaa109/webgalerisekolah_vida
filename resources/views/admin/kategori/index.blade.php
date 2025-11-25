@extends('layouts.admin')

@section('title', 'Kategori - Admin SMKN 4 BOGOR')
@section('page-title', 'Kategori')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Kategori</h5>
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Kategori
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Kategori</th>
                                    <th>Jumlah Posts</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $index => $kategori)
                                <tr>
                                    <td>{{ $kategoris->firstItem() + $index }}</td>
                                    <td>{{ $kategori->judul }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $kategori->posts_count + ($kategori->posts_many_to_many_count ?? 0) }}
                                        </span>
                                    </td>
                                    <td>{{ $kategori->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.kategori.show', $kategori) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada kategori</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $kategoris->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
