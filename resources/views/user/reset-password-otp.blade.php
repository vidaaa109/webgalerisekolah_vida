<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SMKN 4 BOGOR</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #f59e0b;
            --accent-color: #dc2626;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .otp-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .otp-header {
            background: white;
            color: var(--primary-color);
            padding: 2.5rem 2rem;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .otp-header img {
            height: 80px;
            width: auto;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }
        
        .otp-body {
            padding: 2.5rem 2rem;
            background: #fafbfc;
        }
        
        .form-control {
            border-radius: 0.75rem;
            border: 2px solid #e5e7eb;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
            text-align: center;
            letter-spacing: 0.5rem;
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
            transform: translateY(-1px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-link {
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-link:hover {
            color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .otp-title {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .otp-desc {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        
        .school-name {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .user-panel-text {
            font-size: 0.9rem;
            opacity: 0.8;
            font-weight: 500;
        }
        
        .otp-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="otp-container">
                    <div class="otp-header">
                        <img src="/images/logo-smkn4.png.png" alt="SMKN 4 BOGOR">
                        <h4 class="school-name mb-2">SMK Negeri 4 Kota Bogor</h4>
                        <p class="user-panel-text mb-0">Web Galeri Sekolah</p>
                    </div>
                    
                    <div class="otp-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <i class="fas fa-lock otp-icon"></i>
                        </div>
                        
                        <h5 class="otp-title text-center">Verifikasi Kode OTP</h5>
                        <p class="otp-desc text-center">Masukkan kode 6 digit yang telah dikirim ke email Anda.</p>
                        
                        <form method="POST" action="{{ route('user.reset-password-otp.verify') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="otp" class="form-label text-center d-block">Kode OTP</label>
                                <input type="text" class="form-control @error('otp') is-invalid @enderror" 
                                       id="otp" name="otp" maxlength="6" 
                                       placeholder="000000" required autofocus>
                                @error('otp')
                                    <div class="text-danger small mt-1 text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check-circle me-2"></i>Verifikasi
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mb-3">
                            <p class="text-muted mb-2">Tidak menerima kode?</p>
                            <form method="POST" action="{{ route('user.reset-password-otp.resend') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link">
                                    <i class="fas fa-redo me-1"></i>Kirim Ulang OTP
                                </button>
                            </form>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="text-center">
                            <a href="{{ route('user.forgot-password') }}" class="btn-link">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-focus and format OTP input
        const otpInput = document.getElementById('otp');
        otpInput.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
