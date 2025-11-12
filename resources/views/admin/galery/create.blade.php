@extends('layouts.admin')

@section('title', 'Tambah Galeri - Admin SMKN 4 BOGOR')
@section('page-title', 'Tambah Galeri')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Galeri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kategori_filter" class="form-label">Filter Kategori</label>
                                    <select class="form-select" id="kategori_filter">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->judul }}</option>
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
                                                    {{ old('post_id') == $post->id ? 'selected' : '' }}>
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
                                        <option value="custom">Posisi Manual</option>
                                        <option value="last" selected>Posisi Terakhir ({{ $maxPosition + 1 }})</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="position_manual">
                                    <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('position') is-invalid @enderror" 
                                           id="position" name="position" value="{{ old('position', $maxPosition + 1) }}" 
                                           placeholder="Masukkan posisi galeri" min="1" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Posisi terakhir saat ini: {{ $maxPosition }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto-foto (opsional)</label>
                            <div id="g-dropzone" class="border border-2 border-dashed rounded p-4 text-center" style="border-style:dashed; cursor:pointer;">
                                <i class="fa-regular fa-images fa-2x mb-2"></i>
                                <div class="mb-1">Tarik & letakkan gambar di sini atau klik untuk memilih</div>
                                <small class="text-muted">Bisa pilih banyak sekaligus. Format: JPEG, PNG, JPG, GIF.</small>
                                <input type="file" id="g-files" name="files[]" accept="image/*" multiple class="d-none">
                            </div>
                            @error('files')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('files.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="g-preview" class="row g-3 mb-3"></div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.galery.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
  const dz = document.getElementById('g-dropzone');
  const input = document.getElementById('g-files');
  const prev = document.getElementById('g-preview');
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
  
  // Initialize position based on default selection
  if (positionType.value === 'last') {
    positionInput.value = maxPosition;
    positionInput.readOnly = true;
    positionInput.classList.add('bg-light');
  }

  // Dropzone functions
  function humanSize(bytes){
    const u=['B','KB','MB','GB'];let i=0,s=bytes;while(s>1024&&i<u.length-1){s/=1024;i++;}return s.toFixed(1)+' '+u[i];
  }
  function render(files){
    prev.innerHTML='';
    Array.from(files).forEach((f)=>{
      const col=document.createElement('div'); col.className='col-md-4';
      col.innerHTML=`<div class="card h-100"><div class="ratio ratio-4x3 bg-light"><img class="w-100 h-100 object-fit-cover"/></div><div class="card-body p-2"><div class="small text-truncate" title="${f.name}">${f.name}</div><div class="text-muted small">${humanSize(f.size)}</div></div></div>`;
      const img=col.querySelector('img'); const r=new FileReader(); r.onload=e=>img.src=e.target.result; r.readAsDataURL(f);
      prev.appendChild(col);
    });
  }
  dz.addEventListener('click', ()=> input.click());
  dz.addEventListener('dragover', e=>{e.preventDefault(); dz.classList.add('bg-light');});
  dz.addEventListener('dragleave', ()=> dz.classList.remove('bg-light'));
  dz.addEventListener('drop', e=>{ e.preventDefault(); dz.classList.remove('bg-light'); input.files=e.dataTransfer.files; render(input.files); });
  input.addEventListener('change', ()=> render(input.files));
});
</script>
@endpush
