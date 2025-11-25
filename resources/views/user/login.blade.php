<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna - SMKN 4 BOGOR</title>
    
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
        
        .login-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .login-header {
            background: white;
            color: var(--primary-color);
            padding: 2.5rem 2rem;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .login-header img {
            height: 80px;
            width: auto;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }
        
        .login-body {
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
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
            transform: translateY(-1px);
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e5e7eb;
            border-right: none;
            color: var(--primary-color);
            border-radius: 0.75rem 0 0 0.75rem;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.75rem 0.75rem 0;
        }
        
        .input-group .form-control:focus {
            border-left: none;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
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
        
        .btn-outline-secondary {
            border-radius: 0 0.75rem 0.75rem 0;
            border: 2px solid #e5e7eb;
            border-left: none;
        }
        
        .btn-outline-secondary:hover {
            background: #f3f4f6;
            color: var(--primary-color);
        }
        
        .back-link, .forgot-link, .register-link {
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .back-link:hover, .forgot-link:hover, .register-link:hover {
            color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .login-title {
            color: #1f2937;
            font-weight: 700;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container">
                    <div class="login-header">
                        <img src="/images/logo-smkn4.png.png" alt="SMKN 4 BOGOR">
                        <h4 class="school-name mb-2">SMK Negeri 4 Kota Bogor</h4>
                        <p class="user-panel-text mb-0">Web Galeri Sekolah</p>
                    </div>
                    
                    <div class="login-body">
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
                        
                        <h5 class="login-title text-center mb-4">Login Pengguna</h5>
                        
                        <form method="POST" action="{{ route('user.login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="identity" class="form-label">Email atau Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('identity') is-invalid @enderror" 
                                           id="identity" name="identity" value="{{ old('identity') }}" 
                                           placeholder="Masukkan email atau username" required autofocus>
                                </div>
                                @error('identity')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" placeholder="Masukkan password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- reCAPTCHA -->
                            <div class="mb-3">
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                @error('g-recaptcha-response')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mb-3">
                            <a href="{{ route('user.forgot-password') }}" class="forgot-link">
                                <i class="fas fa-key me-1"></i>Lupa Password?
                            </a>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="text-center mb-3">
                            <span class="text-muted">Belum punya akun?</span>
                            <a href="{{ route('user.register') }}" class="register-link ms-1">
                                <i class="fas fa-user-plus me-1"></i>Daftar Pengguna
                            </a>
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('guest.home') }}" class="back-link">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
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
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            const isHidden = password.type === 'password';

            password.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('fa-eye', isHidden);
            icon.classList.toggle('fa-eye-slash', !isHidden);
        });
    </script>
</body>
</html>
