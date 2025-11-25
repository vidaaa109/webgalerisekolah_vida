<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <base href="{{ config('app.url') }}/">
    <title>@yield('title', 'SMKN 4 BOGOR')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #ffffff;
            --accent-color: #dc2626;    
            --dark-bg: #0f172a;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        /* Top Information Bar - Netflix Style */
        .top-info-bar {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1e293b 100%);
            color: var(--secondary-color);
            padding: 12px 0;
            font-size: 14px;
            font-weight: 500;
            box-shadow: var(--shadow-lg);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(0);
            opacity: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .top-info-bar.hidden {
            transform: translateY(-100%);
            opacity: 0;
        }
        
        .top-info-bar .contact-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .top-info-bar .contact-info i {
            color: var(--secondary-color);
            margin-right: 5px;
        }
        
        .top-info-bar .social-media {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .top-info-bar .social-media a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .top-info-bar .social-media a:hover {
            color: var(--secondary-color);
        }
        
        /* Main Navigation Bar - Minimal Clean Professional Style */
        .main-navbar {
            background: #ffffff;
            padding: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
            transition: all 0.3s ease;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .main-navbar .container-fluid {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .main-navbar.with-topbar {
            margin-top: 0;
        }
        
        .navbar-brand {
            color: var(--text-primary) !important;
            padding: 0.75rem 0;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 16px;
        }
        
        .navbar-brand img {
            height: 36px;
            width: auto;
        }
        
        .navbar-brand .school-name {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .navbar-brand .school-name h4 {
            margin: 0;
            font-size: 11px;
            color: #6b7280;
            font-weight: 400;
            letter-spacing: 0.5px;
        }
        
        .navbar-brand .school-name h3 {
            margin: 0;
            font-size: 16px;
            color: var(--primary-color);
            font-weight: 600;
            letter-spacing: 0;
        }
        
        .nav-link {
            color: #4b5563 !important;
            font-weight: 500;
            font-size: 13px;
            padding: 0.75rem 1rem !important;
            transition: all 0.2s ease;
            position: relative;
            border-radius: 0 !important;
            border: none !important;
            letter-spacing: 0;
            text-transform: none;
            background: transparent;
            margin: 0;
        }
        
        .nav-link i {
            font-size: 13px;
            opacity: 0.8;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background: transparent;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .nav-link.active {
            color: var(--primary-color) !important;
            background: transparent;
            font-weight: 600;
        }
        
        .nav-link.active::after {
            width: 80%;
        }
        
        /* Dropdown toggle indicator line - make it consistent */
        .nav-link.dropdown-toggle::before {
            content: none;
        }
        
        /* Override Bootstrap's default dropdown-toggle arrow */
        .dropdown-toggle::after {
            display: none !important;
        }
        
        
        .logout-btn {
            background: none;
            border: none;
            color: #6b7280;
            font-size: 14px;
            padding: 10px 16px;
            transition: all 0.2s ease;
            border-radius: 10px !important;
        }
        
        .logout-btn:hover {
            color: var(--primary-color);
            background-color: rgba(30, 58, 138, 0.08);
            transform: translateX(4px);
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('/images/hero-bg.jpg') center/cover;
            min-height: 500px;
            display: flex;
            align-items: center;
            color: white;
        }
        
        .footer {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
            border-radius: 32px 32px 0 0;
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #3b82f6, #8b5cf6);
        }
        
        .footer h5 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }
        
        .footer p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }
        
        /* Alert Messages - Minimal Style */
        .alert {
            border-radius: 6px !important;
            border: 1px solid;
            padding: 0.875rem 1rem;
            box-shadow: none;
            font-size: 13px;
        }
        
        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }
        
        .alert-info {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 6px !important;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            font-size: 13px;
            transition: all 0.2s ease;
            box-shadow: none;
        }
        
        .btn-primary:hover {
            background: #1e40af;
            transform: none;
            box-shadow: none;
        }
        
        .btn-outline-primary {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            border-radius: 6px !important;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            font-size: 13px;
            transition: all 0.2s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        /* Form Controls - Minimal Style */
        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 6px !important;
            padding: 0.625rem 0.875rem;
            font-size: 13px;
            transition: all 0.2s ease;
            background: #ffffff;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.08);
            background: #ffffff;
            outline: none;
        }
        
        /* Dropdown Menu - Minimal Style */
        .dropdown-menu {
            border-radius: 8px !important;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 0.5rem;
            margin-top: 0 !important;
            min-width: 200px;
        }
        
        .dropdown-item {
            border-radius: 6px !important;
            padding: 0.625rem 1rem;
            margin: 0.125rem 0;
            transition: all 0.2s ease;
            font-size: 13px;
            color: #4b5563;
            font-weight: 500;
            cursor: pointer;
        }
        
        .dropdown-item i {
            width: 20px;
            opacity: 0.7;
        }
        
        .dropdown-item:hover {
            background: #f3f4f6;
            color: var(--primary-color);
        }
        
        /* Ensure dropdown items are clickable */
        .dropdown-item:active {
            background: #e5e7eb;
        }
        
        .dropdown-item.active {
            background: #eff6ff;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
            opacity: 0.1;
        }
        
        /* Dropdown hover effect - keep dropdown visible when hovering menu items */
        .dropdown:hover .dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }
        
        /* Show indicator line when dropdown is hovered - including when hovering dropdown items */
        .dropdown:hover .dropdown-toggle::after,
        .dropdown-menu:hover ~ .dropdown-toggle::after {
            width: 80%;
        }
        
        .dropdown-menu {
            display: none;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        /* Extend dropdown clickable area to prevent gap */
        .dropdown {
            position: relative;
        }
        
        /* Create seamless connection between toggle and dropdown */
        .dropdown-toggle {
            padding-bottom: 0.75rem !important;
        }
        
        /* Invisible bridge to prevent hover gap */
        .dropdown::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            z-index: 1000;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 13px;
        }
        
        /* Rounded Elements - Professional Style */
        .rounded-circle { 
            border-radius: 50% !important; 
        }
        
        .card {
            border-radius: 8px !important;
            border: 1px solid #e5e7eb;
            box-shadow: none;
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: #d1d5db;
        }
        
        .card-header {
            border-radius: 8px 8px 0 0 !important;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .card-body {
            border-radius: 0 0 8px 8px !important;
        }
        
        /* Minimalist Gen Z Design Enhancements */
        .navbar {
            border: none !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .navbar-nav .nav-item {
            border-radius: 0 !important;
        }
        
        .navbar-toggler {
            border-radius: 6px !important;
            border: 1px solid #e5e7eb;
            box-shadow: none;
            padding: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .navbar-toggler:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        
        /* Gen Z Minimalist color scheme */
        .top-info-bar {
            background-color: #0f172a !important;
        }
        
        .main-navbar {
            background-color: #ffffff !important;
        }
        
        /* Page Transition Animations */
        .page-transition {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.6s ease-in-out;
        }
        
        .page-transition.loaded {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Section Animation */
        .section-fade-in {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.8s ease-in-out;
        }
        
        .section-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Ensure main content is visible (no aggressive overrides) */
        main {
            opacity: 1;
            visibility: visible;
        }
        
        /* Button animations - Minimal */
        .btn {
            transition: all 0.2s ease;
        }
        
        
        /* Modern animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Footer minimalist overrides */
        .footer {
            padding: 1.5rem 0;
        }
        .footer .card {
            background: transparent;
            border: 0;
            box-shadow: none;
        }
        .footer .card-header {
            background: transparent;
            color: #e2e8f0;
            border: 0;
            padding: .5rem 1rem;
        }
        .footer .card-header h5 {
            font-size: 1rem;
            margin: 0;
            letter-spacing: .3px;
        }
        .footer .card-body {
            padding: 1rem 1rem 1.25rem;
        }
        .footer .map-container {
            height: 260px !important;
        }
        .footer h5 { font-size: 1rem; }
        .footer p { color: #cbd5e1; margin-bottom: .25rem; }
        .footer label { color: #cbd5e1; font-size: .9rem; }
        .footer .form-control {
            background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.15);
            color: #e5e7eb;
        }
        .footer .form-control::placeholder { color: #94a3b8; }
        .footer .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
            background: rgba(255,255,255,0.08);
        }
        .footer .btn-primary { padding: 8px 16px; border-radius: 6px !important; }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out;
        }
        
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .top-info-bar .contact-info,
            .top-info-bar .social-media {
                justify-content: center;
                margin: 5px 0;
            }
            
            .navbar-brand {
                padding: 0.75rem 0;
            }
            
            .navbar-brand img {
                height: 32px;
            }
            
            .navbar-brand .school-name h3 {
                font-size: 14px;
            }
            
            .navbar-brand .school-name h4 {
                font-size: 10px;
            }
            
            .nav-link {
                text-align: left;
                padding: 0.625rem 0 !important;
                border-bottom: 1px solid #f3f4f6;
            }
            
            .nav-link::after {
                display: none;
            }
            
            .main-navbar .container-fluid {
                padding: 0 1rem;
            }
            
            .navbar-collapse {
                margin-top: 0.5rem;
                padding-top: 0.5rem;
                border-top: 1px solid #e5e7eb;
            }
        }
    </style>
</head>
<body>
    <!-- Top Information Bar -->

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg main-navbar">
    <div class="container-fluid">

        {{-- Logo + Nama Sekolah (Non-clickable) --}}
        <div class="navbar-brand d-flex align-items-center" style="cursor: default;">
            <img src="/images/logo-smkn4.png.png" alt="SMKN 4 BOGOR" style="height:50px; margin-right:10px;">
            <span class="fw-bold">SMKN 4 BOGOR</span>
        </div>

        {{-- Toggle untuk mode mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guest.home') ? 'active' : '' }}" href="{{ route('guest.home') }}">
                        BERANDA
                    </a>
                </li>

                <li class="nav-item ms-3">
                    <a class="nav-link {{ request()->routeIs('guest.galeri*') ? 'active' : '' }}" href="{{ route('guest.galeri') }}">
                        GALERI
                    </a>
                </li>

                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('guest.agenda*') || request()->routeIs('guest.informasi*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        KATEGORI <i class="bi bi-chevron-down ms-1" style="font-size: 12px;"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('guest.informasi*') ? 'active' : '' }}" href="{{ route('guest.informasi') }}">
                            Informasi Terkini
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('guest.agenda*') ? 'active' : '' }}" href="{{ route('guest.agenda') }}">
                            Agenda Sekolah
                        </a></li>
                    </ul>
                </li>

                <li class="nav-item ms-3">
                    <a class="nav-link {{ request()->routeIs('guest.profil') ? 'active' : '' }}" href="{{ route('guest.profil') }}">
                        PROFIL SEKOLAH
                    </a>
                </li>

                <li class="nav-item ms-3">
                    <a class="nav-link {{ request()->routeIs('guest.kontak') ? 'active' : '' }}" href="{{ route('guest.kontak') }}">
                        KONTAK
                    </a>
                </li>

                {{-- Auth area kanan: Guest => tombol Masuk/Daftar; User login => dropdown akun --}}
                @php($userAuth = auth('user'))
                @if($userAuth->check())
                    <li class="nav-item dropdown ms-4">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @php($u = $userAuth->user())
                            @if($u && $u->profile_photo_path)
                                <img src="{{ asset('storage/'.$u->profile_photo_path) }}?v={{ $u?->updated_at?->timestamp ?? time() }}" alt="avatar" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;">
                            @else
                                <span class="me-2 rounded-circle d-inline-flex justify-content-center align-items-center" style="width:32px;height:32px;background:#e2e8f0;color:#64748b;font-weight:700;">{{ strtoupper(substr($u?->name ?? 'U',0,1)) }}</span>
                            @endif
                            <span>{{ $u?->username ?? $u?->name ?? 'Akun' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fa-regular fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('user.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-3">
                        <a class="btn btn-primary" href="{{ route('user.login') }}">Masuk</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>


    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Smooth Scrolling Script -->
    @php($__flash = session()->only(['success','error','warning','info']))
    <script>
        // SweetAlert toast for session messages
        (function(){
            const msgTypes = ['success','error','warning','info'];
            let shown = false;
            const el = {!! json_encode($__flash, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) !!};
            msgTypes.forEach(function(t){
                if (!shown && el && el[t]) {
                    shown = true;
                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: t,
                            title: el[t],
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                }
            });
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for anchor links
            const navLinks = document.querySelectorAll('a[href*="#"]');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Only handle internal anchor links
                    if (href.startsWith('#') || href.includes('#')) {
                        e.preventDefault();
                        
                        const targetId = href.split('#')[1];
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });
            
            // Update active nav link based on scroll position (only on home page)
            const sections = document.querySelectorAll('section[id]');
            const navItems = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
            const berandaLink = document.querySelector('.nav-link[href*="home"]');
            
            function updateActiveNav() {
                // Check if we're on home page
                const isHomePage = window.location.pathname === '/' || window.location.pathname === '';
                
                if (!isHomePage) return;
                
                let current = 'beranda'; // Default to beranda
                const scrollPos = window.pageYOffset || document.documentElement.scrollTop;
                
                // Check which section is currently in view
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    
                    if (scrollPos >= (sectionTop - 300)) {
                        current = section.getAttribute('id');
                    }
                });
                
                // Always keep BERANDA active on home page, unless we're deep in another section
                const shouldKeepBeranda = scrollPos < 400 || current === 'beranda';
                
                // Update active state for navbar items
                navItems.forEach(item => {
                    const itemText = item.textContent.trim();
                    
                    // Remove active from all first
                    item.classList.remove('active');
                    
                    // Add active to BERANDA when at top or in beranda section
                    if (itemText === 'BERANDA' && shouldKeepBeranda) {
                        item.classList.add('active');
                    }
                });
            }
            
            // Only run scroll detection on home page
            if (window.location.pathname === '/' || window.location.pathname === '') {
                window.addEventListener('scroll', updateActiveNav, { passive: true });
                updateActiveNav(); // Call once on load
                
                // Ensure BERANDA is active on page load
                if (berandaLink) {
                    berandaLink.classList.add('active');
                }
            }
            
            // Dropdown hover functionality
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu');
                
                if (toggle && menu) {
                    let hideTimeout;
                    
                    // Show on hover (desktop)
                    if (window.innerWidth > 991) {
                        // Show dropdown when hovering dropdown container
                        dropdown.addEventListener('mouseenter', function() {
                            clearTimeout(hideTimeout);
                            menu.classList.add('show');
                            toggle.setAttribute('aria-expanded', 'true');
                        });
                        
                        // Keep dropdown visible when hovering the menu itself
                        menu.addEventListener('mouseenter', function() {
                            clearTimeout(hideTimeout);
                            menu.classList.add('show');
                            toggle.setAttribute('aria-expanded', 'true');
                        });
                        
                        // Hide on mouse leave from dropdown container
                        dropdown.addEventListener('mouseleave', function(e) {
                            // Only hide if not moving to menu
                            if (!menu.contains(e.relatedTarget)) {
                                hideTimeout = setTimeout(() => {
                                    menu.classList.remove('show');
                                    toggle.setAttribute('aria-expanded', 'false');
                                }, 100);
                            }
                        });
                        
                        // Hide on mouse leave from menu
                        menu.addEventListener('mouseleave', function() {
                            hideTimeout = setTimeout(() => {
                                menu.classList.remove('show');
                                toggle.setAttribute('aria-expanded', 'false');
                            }, 100);
                        });
                    }
                    
                    // Click functionality for mobile
                    toggle.addEventListener('click', function(e) {
                        if (window.innerWidth <= 991) {
                            e.preventDefault();
                            menu.classList.toggle('show');
                            const isExpanded = menu.classList.contains('show');
                            toggle.setAttribute('aria-expanded', isExpanded);
                        } else {
                            // On desktop, prevent toggle click but allow dropdown items to be clicked
                            e.preventDefault();
                        }
                    });
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        menu.classList.remove('show');
                        const toggle = menu.closest('.dropdown')?.querySelector('.dropdown-toggle');
                        if (toggle) toggle.setAttribute('aria-expanded', 'false');
                    });
                }
            });
            
            // Pastikan konten utama terlihat (tanpa mengganggu komponen Bootstrap)
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.style.opacity = '1';
                mainContent.style.visibility = 'visible';
            }
            
            // HINDARI memaksa semua elemen menjadi terlihat karena dapat mengganggu .modal/.dropdown
            // Jika ingin memastikan elemen tertentu muncul, targetkan selektor yang aman saja.
        });
    </script>

    <!-- Footer Minimalis -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <!-- Kolom Kiri: Logo & Alamat -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="d-flex align-items-center mb-3">
                        <img src="/images/logo-smkn4.png.png" alt="Logo SMKN 4 BOGOR" style="height: 50px; margin-right: 15px;">
                        <h5 class="mb-0">SMKN 4 BOGOR</h5>
                    </div>
                    <p class="mb-2 small">
                        <i class="fas fa-map-marker-alt me-2"></i> 
                        Jl. Raya Tajur, Kp. Buntar RT.02/RW.08, Kel. Muara sari, Kec. Bogor Selatan, Kota Bogor, Jawa Barat 16137
                    </p>
                </div>

                <!-- Kolom Tengah: Kontak -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h6 class="mb-3">Kontak Kami</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i> 0251-7547381
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i> smkn4@smkn4bogor.sch.id
                        </li>
                        <li>
                            <i class="fas fa-clock me-2"></i> Senin-Jumat: 07.00-16.00 WIB
                        </li>
                    </ul>
                </div>

                <!-- Kolom Kanan: Sosial Media -->
                <div class="col-md-4">
                    <h6 class="mb-3">Ikuti Kami</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="https://www.facebook.com/share/17CtNSgSXu/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/smkn4kotabogor?igsh=MXUzeG13b2szbDlpMA==" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="https://youtube.com/@smknegeri4bogor905?si=FecUBrkfaNSZzX30" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                    
                    <!-- Tombol Hubungi Kami -->
                    <div class="mt-4">
                        <a href="{{ route('guest.kontak') }}" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>

            <!-- Garis Pemisah -->
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <!-- Copyright -->
            <div class="text-center small">
                <p class="mb-0">&copy; {{ date('Y') }} SMKN 4 BOGOR. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Scroll Effect Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const topInfoBar = document.querySelector('.top-info-bar');
            const mainNavbar = document.querySelector('.main-navbar');
            let lastScrollTop = 0;
            let ticking = false;
            
            function updateNavbar() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Jalankan hanya jika elemen tersedia (hindari error JS)
                if (topInfoBar && mainNavbar) {
                    // Tampilkan top bar saat di paling atas
                    if (scrollTop === 0) {
                        topInfoBar.classList.remove('hidden');
                        mainNavbar.classList.add('with-topbar');
                    } else {
                        // Sembunyikan saat scroll turun
                        topInfoBar.classList.add('hidden');
                        mainNavbar.classList.remove('with-topbar');
                    }
                }
                
                lastScrollTop = scrollTop;
                ticking = false;
            }
            
            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateNavbar);
                    ticking = true;
                }
            }
            
            // Daftarkan listener hanya jika salah satu elemen ada
            if (topInfoBar || mainNavbar) {
                window.addEventListener('scroll', requestTick, { passive: true });
            }
            
            // Inisialisasi state navbar bila elemen ada
            if (topInfoBar && mainNavbar) {
                topInfoBar.classList.remove('hidden');
                mainNavbar.classList.add('with-topbar');
            }
        });
    </script>
    
    
    @stack('scripts')
    
    
</body>
</html>
