@extends('layouts.petugas')

@section('title', 'Upload Foto - Petugas SMKN 4 BOGOR')
@section('page-title', 'Upload Foto')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Upload Foto</h5>
                </div>
                <div class="card-body">
                    <form id="fotoUploadForm" action="{{ route('petugas.foto.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="galery_id" class="form-label">Galeri</label>
                            <select class="form-select @error('galery_id') is-invalid @enderror" 
                                    id="galery_id" name="galery_id" required>
                                <option value="">Pilih Galeri</option>
                                @foreach($galeries as $galery)
                                    <option value="{{ $galery->id }}" 
                                            {{ old('galery_id') == $galery->id ? 'selected' : '' }}>
                                        {{ $galery->post->judul }} (Posisi: {{ $galery->position }})
                                    </option>
                                @endforeach
                            </select>
                            @error('galery_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">File Foto</label>
                            <div id="dropzone" class="border border-2 border-dashed rounded p-4 text-center" style="border-style:dashed; cursor:pointer;">
                                <i class="fa-regular fa-images fa-2x mb-2"></i>
                                <div class="mb-1">Tarik & letakkan gambar di sini atau klik untuk memilih</div>
                                <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Bisa pilih banyak sekaligus.</small>
                                <input type="file" id="files" name="files[]" accept="image/*" multiple class="d-none">
                            </div>
                            @error('files')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('files.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="previewGrid" class="row g-3 mb-3"></div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('petugas.foto.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('dropzone');
    const input = document.getElementById('files');
    const preview = document.getElementById('previewGrid');

    function humanSize(bytes){
        const units=['B','KB','MB','GB'];
        let i=0; let s=bytes;
        while(s>1024 && i<units.length-1){ s/=1024; i++; }
        return s.toFixed(1)+' '+units[i];
    }

    function renderPreview(files){
        preview.innerHTML='';
        Array.from(files).forEach((file)=>{
            const col = document.createElement('div');
            col.className = 'col-md-4';
            col.innerHTML = `
                <div class="card h-100">
                    <div class="ratio ratio-4x3 bg-light">
                        <img class="w-100 h-100 object-fit-cover" src="" alt="preview" />
                    </div>
                    <div class="card-body p-2">
                        <div class="small text-truncate" title="${file.name}">${file.name}</div>
                        <div class="text-muted small">${humanSize(file.size)}</div>
                    </div>
                </div>`;
            const img = col.querySelector('img');
            const reader = new FileReader();
            reader.onload = e => img.src = e.target.result;
            reader.readAsDataURL(file);
            preview.appendChild(col);
        });
    }

    dropzone.addEventListener('click', () => input.click());

    dropzone.addEventListener('dragover', function(e){
        e.preventDefault();
        dropzone.classList.add('bg-light');
    });

    dropzone.addEventListener('dragleave', function(){
        dropzone.classList.remove('bg-light');
    });

    dropzone.addEventListener('drop', function(e){
        e.preventDefault();
        dropzone.classList.remove('bg-light');
        if(e.dataTransfer.files && e.dataTransfer.files.length){
            input.files = e.dataTransfer.files;
            renderPreview(e.dataTransfer.files);
        }
    });

    input.addEventListener('change', function(e){
        if(e.target.files && e.target.files.length){
            renderPreview(e.target.files);
        } else {
            preview.innerHTML='';
        }
    });
});
</script>
@endpush
