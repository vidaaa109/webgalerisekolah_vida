@extends('layouts.admin')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan Per Tabel')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Download CSV</h5>
                <p class="text-muted">Pilih jenis data dan rentang tanggal (opsional) untuk diunduh.</p>
                <form method="GET" action="{{ route('admin.reports.export.download') }}">
                    <div class="mb-3">
                        <label class="form-label">Jenis Data</label>
                        <select name="type" class="form-select" required>
                            <option value="">Pilih satu</option>
                            <option value="galery">Galeri</option>
                            <option value="likes">Like</option>
                            <option value="comments">Komentar</option>
                            <option value="bookmarks">Simpan</option>
                            <option value="users">Pengguna</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="from" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="to" class="form-control">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-download me-1"></i> Unduh CSV
                        </button>
                        <button type="button" class="btn btn-danger" id="btnExportPdf">
                            <i class="bi bi-file-pdf me-1"></i> Unduh PDF
                        </button>
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
    const pdfBtn = document.getElementById('btnExportPdf');
    if (pdfBtn) {
        pdfBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const type = document.querySelector('select[name=type]').value;
            const from = document.querySelector('input[name=from]').value;
            const to = document.querySelector('input[name=to]').value;
            
            if (!type) {
                alert('Pilih jenis data terlebih dahulu');
                return;
            }
            
            let url = '{{ route("admin.reports.export.pdf") }}?type=' + type;
            if (from) url += '&from=' + from;
            if (to) url += '&to=' + to;
            
            window.location.href = url;
        });
    }
});
</script>
@endpush

