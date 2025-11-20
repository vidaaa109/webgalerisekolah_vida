@extends('layouts.petugas')

@section('title', 'Posts - Petugas SMKN 4 BOGOR')
@section('page-title', 'Posts')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Posts</h5>
                    <a href="{{ route('petugas.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Post
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th class="d-none d-md-table-cell">Kategori</th>
                                    <th class="d-none d-lg-table-cell">Petugas</th>
                                    <th>Status</th>
                                    <th class="d-none d-xl-table-cell">Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $index => $post)
                                <tr>
                                    <td>{{ $posts->firstItem() + $index }}</td>
                                    <td>
                                        <div>{{ Str::limit($post->judul, 50) }}</div>
                                        <small class="text-muted d-md-none">{{ $post->kategori->judul }}</small>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="badge bg-info">{{ $post->kategori->judul }}</span>
                                        @if($post->kategoris->count() > 0)
                                            <div class="mt-1">
                                                @foreach($post->kategoris as $kat)
                                                    <span class="badge bg-secondary me-1">{{ $kat->judul }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell">{{ $post->petugas->username }}</td>
                                    <td>
                                        <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td class="d-none d-xl-table-cell">{{ $post->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('petugas.posts.show', $post) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('petugas.posts.edit', $post) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('petugas.posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus post ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada posts</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
