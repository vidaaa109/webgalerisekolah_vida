<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <base href="{{ config('app.url') }}/">
    <title>@yield('title', 'Admin Dashboard - SMKN 4 BOGOR')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #f59e0b;
            --accent-color: #dc2626;
            --sidebar-width: 250px;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: #0f172a;
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .sidebar-header img {
            height: 52px;
            width: auto;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0.25rem 1rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            text-decoration: none;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .content-wrapper {
            padding: 2rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 0.75rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/images/logo-smkn4.png.png" alt="SMKN 4 BOGOR">
            <h6 class="mb-0">SMKN 4 BOGOR</h6>
            <small>Admin Panel</small>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>POST</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>KATEGORI</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.galery.index') }}" class="nav-link {{ request()->routeIs('admin.galery*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <span>GALERI</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.foto.index') }}" class="nav-link {{ request()->routeIs('admin.foto*') ? 'active' : '' }}">
                    <i class="fas fa-camera"></i>
                    <span>FOTO</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.petugas.index') }}" class="nav-link {{ request()->routeIs('admin.petugas*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>PETUGAS</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.profile.index') }}" class="nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                    <i class="fas fa-info-circle"></i>
                    <span>PROFIL</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span>TESTIMONI</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>PENGGUNA</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                    <i class="fas fa-flag"></i>
                    <span>LAPORAN</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.reports.export.form') }}" class="nav-link {{ request()->routeIs('admin.reports.export.*') ? 'active' : '' }}">
                    <i class="fas fa-table"></i>
                    <span>EXPORT TABEL</span>
                </a>
            </div>
            
            <hr class="mx-3">
            
            <div class="nav-item">
                <a href="{{ route('admin.logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0 ms-2">@yield('page-title', 'Dashboard')</h4>
            </div>
            
            <div class="d-flex align-items-center">
                <span class="me-3">Selamat datang, {{ Auth::guard('admin')->user()->name ?? Auth::guard('admin')->user()->username }}</span>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    
    @stack('scripts')
</body>
</html>
