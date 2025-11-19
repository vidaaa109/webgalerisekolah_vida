@extends('layouts.app')

@section('title', 'Beranda - SMKN 4 BOGOR')

@section('content')
<style>
    /* Hero Slideshow Styles - Netflix Style */
    .hero-slideshow {
        position: relative;
        height: 100vh;
        overflow: hidden;
        background: transparent;
    }
    
    .slideshow-container {
        position: relative;
        width: 100%;
        height: 100%;
    }
    
    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 1s ease-in-out;
        z-index: 1;
    }
    
    .slide.active {
        opacity: 1;
        visibility: visible;
        z-index: 1;
    }
    
    .slide-bg {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0.4) 100%);
        z-index: 2;
        backdrop-filter: blur(1px);
    }
    
    .hero-cta-buttons {
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .hero-cta-btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.85rem 2.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        border-width: 0;
        letter-spacing: 0.02em;
    }
    
    .hero-cta-btn-primary {
        background-color: var(--primary-color);
        color: #ffffff;
    }
    
    .hero-cta-btn-primary:hover {
        background-color: #1e40af;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.3);
    }
    
    .hero-cta-btn-outline {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.85);
        color: #ffffff;
    }
    
    .hero-cta-btn-outline:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
    }
    
    .slide-indicators {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 15px;
        z-index: 3;
    }
    
    .indicator {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .indicator.active {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        transform: scale(1.3);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    .indicator:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
        transform: scale(1.1);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-slideshow {
            height: 70vh;
        }
        
        .hero-overlay .display-4 {
            font-size: 2rem;
        }
        
        .hero-overlay .lead {
            font-size: 1rem;
        }
        
        .slide-indicators {
            bottom: 20px;
        }
    }
</style>
    <!-- Hero Section with Slideshow -->
    <section id="beranda" class="hero-slideshow">
        <div class="slideshow-container">
            <!-- Single Static Image -->
            <div class="slide active">
                <div class="slide-bg" style="background-image: url('/images/dashboarad.JPG');"></div>
            </div>
        </div>
        
        <!-- Overlay Content -->
        <div class="hero-overlay">
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-6 animate-fadeInUp">
                        <h1 class="display-3 fw-bold mb-4 text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5); animation-delay: 0.2s;">Selamat Datang di SMKN 4 BOGOR</h1>
                        <p class="lead mb-4 text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5); font-size: 1.1rem; animation-delay: 0.4s;">
                        SMKN 4 Bogor, sekolah kejuruan yang fokus membentuk siswa berkompeten, terampil, dan siap bersaing di dunia industri.   
                        </p>
                        <div class="d-flex hero-cta-buttons animate-slideInLeft" style="animation-delay: 0.6s;">
                            <a href="{{ route('guest.profil') }}" class="btn btn-lg hero-cta-btn hero-cta-btn-primary">
                                Lihat Profil Sekolah
                            </a>
                            <a href="{{ route('guest.galeri') }}" class="btn btn-lg hero-cta-btn hero-cta-btn-outline">
                                Lihat Galeri
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>

    <!-- Profil Section inside Home -->
    <section id="profil" class="py-5 bg-light section-fade-in animate-fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if($profile)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h2 class="card-title text-primary mb-4">{{ str_replace('Sekolah Kita', 'SMKN 4 Bogor', $profile->judul) }}</h2>
                                <div class="profile-content">
                                    {!! nl2br(e(str_replace('Sekolah Kita', 'SMKN 4 Bogor', $profile->isi))) !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h2 class="fw-bold text-primary mb-3">Profil SMKN 4 BOGOR</h2>
                                <p class="text-muted">SMKN 4 BOGOR berkomitmen untuk mencetak lulusan yang berkarakter, kompeten, dan siap bersaing di dunia kerja maupun perguruan tinggi. Dengan dukungan fasilitas modern, kurikulum berbasis industri, dan guru-guru profesional, kami terus berinovasi untuk mewujudkan pendidikan vokasi yang berkualitas.</p>
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Fasilitas lengkap dan modern</li>
                                    <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Kurikulum link & match dengan industri</li>
                                    <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Prestasi akademik dan non-akademik</li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Vision & Mission -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4 text-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fas fa-eye fa-2x text-primary"></i>
                                    </div>
                                    <h5 class="card-title">Visi</h5>
                                    <p class="card-text text-muted">
                                        "Menjadi SMK Unggulan yang menghasilkan lulusan berkualitas, berkarakter, dan siap kerja sesuai standar industri nasional dan internasional."
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4 text-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fas fa-bullseye fa-2x text-success"></i>
                                    </div>
                                    <h5 class="card-title">Misi</h5>
                                    <p class="card-text text-muted">
                                        "Menyelenggarakan pendidikan kejuruan yang berkualitas, mengembangkan potensi siswa secara optimal, dan membangun kerjasama dengan dunia industri."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Quick Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Informasi Sekolah</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">Alamat</h6>
                                    <p class="mb-0 small text-muted">Jl. Raya Tajur, Kp. Buntar RT.02/RW.08, Kel. Muara sari, Kec. Bogor Selatan, RT.03/RW.08, Muarasari, Kec. Bogor Sel., Kota Bogor, Jawa Barat 16137</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-phone text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">Telepon</h6>
                                    <p class="mb-0 small text-muted">02517547381</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-envelope text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">Email</h6>
                                    <p class="mb-0 small text-muted">smkn4@smkn4bogor.sch.id</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-globe text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">Website</h6>
                                    <p class="mb-0 small text-muted">http://smkn4bogor.sch.id</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jurusan -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Program Keahlian</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Teknik Komputer dan Jaringan
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Rekayasa Perangkat Lunak
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Teknik Pengelasan Fabrikasi Logam 
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Teknik Otomotif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="keunggulan" class="py-5 section-fade-in animate-fadeInUp">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold text-primary">Keunggulan Kami</h2>
                    <p class="lead text-muted">Mengapa memilih SMKN 4 BOGOR?</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                            </div>
                            <h5 class="card-title">Akreditasi A</h5>
                            <p class="card-text text-muted">Semua jurusan telah terakreditasi A dengan standar nasional yang tinggi.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-briefcase fa-2x text-success"></i>
                            </div>
                            <h5 class="card-title">Link & Match</h5>
                            <p class="card-text text-muted">Kerjasama dengan industri untuk memastikan lulusan siap kerja.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-award fa-2x text-warning"></i>
                            </div>
                            <h5 class="card-title">Prestasi Tinggi</h5>
                            <p class="card-text text-muted">Siswa berprestasi di berbagai kompetisi nasional dan internasional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Agenda Sekolah Section -->
    <section id="agenda" class="py-5 bg-light section-fade-in animate-fadeInUp">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-primary">Agenda Sekolah</h2>
                        <p class="lead text-muted">Kegiatan dan acara mendatang SMKN 4 BOGOR</p>
                    </div>
                    <a href="{{ route('guest.agenda') }}" class="btn btn-primary">
                        Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="row g-4">
                @forelse($latestAgenda as $agenda)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3" style="min-width: 70px;">
                                    <div class="text-center">
                                        <div class="fw-bold text-primary" style="font-size: 1.5rem;">{{ $agenda->created_at->format('d') }}</div>
                                        <div class="text-muted small">{{ $agenda->created_at->format('M') }}</div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="card-title fw-bold mb-2">{{ Str::limit($agenda->judul, 50) }}</h6>
                                    <p class="card-text text-muted small mb-0">{{ Str::limit(strip_tags($agenda->isi), 60) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('guest.agenda.show', $agenda) }}" class="btn btn-outline-primary btn-sm w-100">
                                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada agenda tersedia</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Informasi Terkini Section -->
    <section id="informasi" class="py-5 section-fade-in animate-fadeInUp">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-primary">Informasi Terkini</h2>
                        <p class="lead text-muted">Berita dan informasi terbaru dari SMKN 4 BOGOR</p>
                    </div>
                    <a href="{{ route('guest.informasi') }}" class="btn btn-primary">
                        Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="row g-4">
                @forelse($latestInformasi as $info)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <span class="badge bg-primary mb-3">{{ $info->kategori->judul }}</span>
                            <h5 class="card-title fw-bold">{{ $info->judul }}</h5>
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($info->isi), 120) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i>
                                    {{ $info->created_at->format('d M Y') }}
                                </small>
                                <a href="{{ route('guest.informasi.show', $info) }}" class="btn btn-outline-primary btn-sm">
                                    Baca Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada informasi tersedia</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimoni" class="py-5 bg-light section-fade-in animate-fadeInUp">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold text-primary">Testimoni</h2>
                    <p class="lead text-muted">Apa kata mereka tentang SMKN 4 BOGOR</p>
                    <div class="mx-auto" style="width: 60px; height: 3px; background: linear-gradient(90deg, #0b244d, var(--primary-color));"></div>
                </div>
            </div>
            
            <div class="row g-4" id="testimonialsContainer">
                <!-- Testimonials will be loaded here via JavaScript -->
                <div class="col-12 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat testimoni...</p>
                </div>
            </div>
            
            <!-- CTA Button to Contact Page -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="{{ route('guest.kontak') }}" class="btn btn-primary btn-lg px-5 shadow">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Testimoni Anda
                    </a>
                    <p class="text-muted mt-3 small">Bagikan pengalaman Anda di SMKN 4 BOGOR</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section dipindahkan ke footer -->

    <!-- JavaScript for Slideshow -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const indicators = document.querySelectorAll('.indicator');
            let currentSlide = 0;
            
            // Slideshow disabled - using single static image
            
            // Load Testimonials
            loadTestimonials();
            
            // Testimonial Form Handler
            const testimonialForm = document.getElementById('testimonialForm');
            const submitBtn = document.getElementById('submitBtn');
            const alertContainer = document.getElementById('alertContainer');
            
            if (testimonialForm) {
                testimonialForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Disable submit button
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                    
                    // Get form data
                    const formData = new FormData(this);
                    
                    // Send AJAX request
                    fetch('{{ route("testimonial.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showAlert('success', data.message);
                            testimonialForm.reset();
                        } else {
                            showAlert('danger', data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('danger', 'Terjadi kesalahan saat mengirim pesan: ' + error.message);
                    })
                    .finally(() => {
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Pesan';
                    });
                });
            }
            
            function showAlert(type, message) {
                alertContainer.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                // Auto hide after 5 seconds
                setTimeout(() => {
                    const alert = alertContainer.querySelector('.alert');
                    if (alert) {
                        alert.remove();
                    }
                }, 5000);
            }
            
            // Load Testimonials Function
            function loadTestimonials() {
                fetch('{{ route("testimonials.approved") }}')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('testimonialsContainer');
                        
                        if (data.success && data.data.length > 0) {
                            container.innerHTML = data.data.map(testimonial => {
                                const formattedDate = new Date(testimonial.created_at).toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric',
                                });
                                return `
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">${testimonial.nama}</h6>
                                                    <small class="text-muted">${formattedDate}</small>
                                                </div>
                                            </div>
                                            <p class="card-text text-muted">"${testimonial.pesan}"</p>
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            }).join('');
                        } else {
                            container.innerHTML = `
                                <div class="col-12 text-center">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-5">
                                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada testimoni</h5>
                                            <p class="text-muted">Jadilah yang pertama memberikan testimoni tentang SMKN 4 BOGOR!</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading testimonials:', error);
                        const container = document.getElementById('testimonialsContainer');
                        container.innerHTML = `
                            <div class="col-12 text-center">
                                <div class="alert alert-warning" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Gagal memuat testimoni. Silakan refresh halaman.
                                </div>
                            </div>
                        `;
                    });
            }
        });
    </script>
@endsection
