@extends('layouts.app')

@section('title', 'Edit Profil - SMKN 4 BOGOR')

@section('content')
<style>
    .edit-profile-wrap { max-width: 600px; margin: 0 auto; padding: 1rem; }
    
    /* Header clean */
    .profile-header { 
        background: white; 
        border-radius: 24px 24px 0 0; 
        padding: 2.5rem 1.5rem 1.5rem; 
        position: relative;
        border-bottom: 1px solid #e2e8f0;
    }
    
    /* Avatar section */
    .avatar-section { position: relative; z-index: 1; }
    .profile-photo-preview { 
        width: 140px; 
        height: 140px; 
        border-radius: 50%; 
        object-fit: cover; 
        border: 5px solid #f1f5f9; 
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        margin: 0 auto; 
        transition: transform 0.3s ease;
    }
    .profile-photo-preview:hover { transform: scale(1.05); }
    .profile-photo-placeholder { 
        width: 140px; 
        height: 140px; 
        border-radius: 50%; 
        background: #e2e8f0;
        color: #64748b; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 3.5rem; 
        font-weight: 700; 
        margin: 0 auto; 
        border: 5px solid #f1f5f9;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    .profile-photo-placeholder:hover { transform: scale(1.05); }
    
    /* Form card */
    .form-card { 
        background: white; 
        border-radius: 0 0 24px 24px; 
        padding: 2rem; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    /* Input styling */
    .form-control, .input-group { border-radius: 12px; }
    .form-control { 
        border: 2px solid #e2e8f0; 
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    .form-control:focus { 
        border-color: #3b82f6; 
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15);
    }
    .input-group-text { 
        background: #f8fafc; 
        border: 2px solid #e2e8f0; 
        border-right: none;
        border-radius: 12px 0 0 12px;
        font-weight: 600;
        color: #3b82f6;
    }
    .input-group .form-control { border-left: none; border-radius: 0 12px 12px 0; }
    
    /* Label */
    .form-label { 
        font-weight: 600; 
        color: #1e293b; 
        margin-bottom: 0.5rem;
        font-size: 14px;
    }
    
    /* Buttons */
    .btn-save { 
        background: #3b82f6;
        border: none;
        color: white;
        padding: 12px 32px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }
    .btn-save:hover { 
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .btn-cancel {
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        color: #64748b;
        padding: 12px 32px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-cancel:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
        color: #475569;
    }
    
    /* Back button */
    .back-btn-edit { 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        color: #64748b;
        text-decoration: none; 
        font-weight: 600; 
        padding: 10px 20px; 
        border-radius: 50px; 
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .back-btn-edit:hover { 
        background: #f8fafc;
        color: #475569;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    
    @media (max-width: 767.98px) {
        .form-card { padding: 1.5rem; }
        .profile-header { padding: 2rem 1rem 1rem; }
    }
</style>

<section class="py-4">
    <div class="container edit-profile-wrap">
        <div class="mb-3">
            <a href="{{ route('user.profile') }}" class="back-btn-edit">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Profil</span>
            </a>
        </div>

        <form method="POST" action="{{ route('user.profile.update') }}" id="profileForm">
            @csrf
            @method('PUT')

            <!-- Header with gradient and avatar -->
            <div class="profile-header">
                <div class="avatar-section text-center">
                    <div>
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/'.$user->profile_photo_path) }}?v={{ time() }}" class="profile-photo-preview" alt="Profile Photo">
                        @else
                            <div class="profile-photo-placeholder">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form card -->
            <div class="form-card">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>{{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="bi bi-person me-1"></i>Nama Lengkap
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="bi bi-at me-1"></i>Username
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">@</span>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                               id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text"><i class="bi bi-info-circle me-1"></i>Username harus unik, hanya huruf kecil, angka, dan underscore</div>
                </div>

                <!-- Email (Read-only) -->
                <div class="mb-4">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-1"></i>Email
                    </label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly disabled style="background: #f8fafc; cursor: not-allowed;">
                    <div class="form-text"><i class="bi bi-info-circle me-1"></i>Email tidak dapat diubah</div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                    <a href="{{ route('user.profile') }}" class="btn-cancel">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
// Validasi username - hanya huruf, angka, dan underscore
document.getElementById('username').addEventListener('input', function(e) {
    this.value = this.value.toLowerCase().replace(/[^a-z0-9_]/g, '');
});
</script>
@endsection
