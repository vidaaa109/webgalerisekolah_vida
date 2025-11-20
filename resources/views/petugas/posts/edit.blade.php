@extends('layouts.petugas')

@section('title', 'Edit Post - Petugas SMKN 4 BOGOR')
@section('page-title', 'Edit Post')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Edit Post</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.posts.update', $post) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Post</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" value="{{ old('judul', $post->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isi" class="form-label">Isi Post</label>
                                    <textarea class="form-control @error('isi') is-invalid @enderror" 
                                              id="isi" name="isi" rows="10" required>{{ old('isi', $post->isi) }}</textarea>
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori Utama <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                            id="kategori_id" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" 
                                                    {{ old('kategori_id', $post->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kategori Tambahan (Multiple)</label>
                                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                        @foreach($kategoris as $kategori)
                                            @php
                                                $isChecked = false;
                                                if(is_array(old('kategori_ids'))){
                                                    $isChecked = in_array($kategori->id, old('kategori_ids'));
                                                } else {
                                                    $isChecked = $post->kategoris->contains($kategori->id);
                                                }
                                            @endphp
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="kategori_ids[]" value="{{ $kategori->id }}" 
                                                       id="kat_{{ $kategori->id }}"
                                                       {{ $isChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kat_{{ $kategori->id }}">
                                                    {{ $kategori->judul }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Pilih kategori tambahan jika post termasuk dalam beberapa kategori</small>
                                    @error('kategori_ids')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('petugas.posts.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
