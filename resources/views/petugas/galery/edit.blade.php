@extends('layouts.petugas')

@section('title', 'Edit Galeri - Petugas SMKN 4 BOGOR')
@section('page-title', 'Edit Galeri')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Edit Galeri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.galery.update', $galery) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kategori_filter" class="form-label">Filter Kategori</label>
                                    <select class="form-select" id="kategori_filter">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $galery->post->kategori_id == $category->id ? 'selected' : '' }}>{{ $category->judul }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Pilih kategori untuk memfilter post</small>
                                </div>
                                <div class="mb-3">
                                    <label for="post_id" class="form-label">Post <span class="text-danger">*</span></label>
                                    <select class="form-select @error('post_id') is-invalid @enderror" 
                                            id="post_id" name="post_id" required>
                                        <option value="">Pilih Post</option>
                                        @foreach($posts as $post)
                                            <option value="{{ $post->id }}" 
                                                    data-kategori="{{ $post->kategori_id }}"
                                                    {{ old('post_id', $galery->post_id) == $post->id ? 'selected' : '' }}>
                                                {{ $post->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('post_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position_type" class="form-label">Tipe Posisi</label>
                                    <select class="form-select" id="position_type">
                                        <option value="custom" selected>Posisi Manual</option>
                                        <option value="last">Posisi Terakhir ({{ $maxPosition + 1 }})</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="position_manual">
                                    <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('position') is-invalid @enderror" 
                                           id="position" name="position" value="{{ old('position', $galery->position) }}" 
                                           placeholder="Masukkan posisi galeri" min="1" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Posisi saat ini: {{ $galery->position }} | Posisi terakhir: {{ $maxPosition }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="1" {{ old('status', $galery->status) == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status', $galery->status) == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('petugas.galery.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const kategoriFilter = document.getElementById('kategori_filter');
  const postSelect = document.getElementById('post_id');
  const positionType = document.getElementById('position_type');
  const positionInput = document.getElementById('position');
  const maxPosition = {{ $maxPosition + 1 }};

  // Category filter for posts
  kategoriFilter.addEventListener('change', function() {
    const selectedKategori = this.value;
    const options = postSelect.querySelectorAll('option');
    
    options.forEach(option => {
      if (option.value === '') {
        option.style.display = 'block';
        return;
      }
      
      const optionKategori = option.getAttribute('data-kategori');
      if (selectedKategori === '' || optionKategori === selectedKategori) {
        option.style.display = 'block';
      } else {
        option.style.display = 'none';
      }
    });
    
    // Reset post selection if current selection is hidden
    if (postSelect.value) {
      const currentOption = postSelect.querySelector(`option[value="${postSelect.value}"]`);
      if (currentOption && currentOption.style.display === 'none') {
        postSelect.value = '';
      }
    }
  });

  // Position type handler
  positionType.addEventListener('change', function() {
    if (this.value === 'last') {
      positionInput.value = maxPosition;
      positionInput.readOnly = true;
      positionInput.classList.add('bg-light');
    } else {
      positionInput.readOnly = false;
      positionInput.classList.remove('bg-light');
    }
  });
});
</script>
@endpush
