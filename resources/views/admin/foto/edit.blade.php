@extends('layouts.admin')

@section('title', 'Edit Foto - Admin SMKN 4 BOGOR')
@section('page-title', 'Edit Foto')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Edit Foto</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.foto.update', $foto) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="galery_id" class="form-label">Galeri</label>
                            <select class="form-select @error('galery_id') is-invalid @enderror" 
                                    id="galery_id" name="galery_id" required>
                                <option value="">Pilih Galeri</option>
                                @foreach($galeries as $galery)
                                    <option value="{{ $galery->id }}" 
                                            {{ old('galery_id', $foto->galery_id) == $galery->id ? 'selected' : '' }}>
                                        {{ $galery->post->judul }} (Position: {{ $galery->position }})
                                    </option>
                                @endforeach
                            </select>
                            @error('galery_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File Foto Baru (Opsional)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" accept="image/*">
                            <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($foto->file)
                        <div class="mb-3">
                            <label class="form-label">Foto Saat Ini</label>
                            <div>
                                <img src="{{ Storage::url($foto->file) }}" alt="Foto {{ $foto->galery->post->judul }}" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.foto.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
