@extends('layouts.app')

@section('title', 'Kontak - SMKN 4 BOGOR')

@section('content')
    <style>
        .contact-title {
            font-weight: 700;
            color: #0f172a;
            font-size: 2rem;
        }
        .contact-subtitle {
            color: #4b5563;
            font-size: 1rem;
        }
    </style>

    <!-- Contact Section -->
    <section id="kontak" class="py-5 section-fade-in">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="contact-title mb-2">Hubungi Kami</h2>
                    <p class="contact-subtitle mb-0">Kami siap membantu dan menjawab pertanyaan Anda</p>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Kolom Kiri: Google Maps -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Denah Lokasi</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="map-container" style="height: 400px; overflow: hidden;">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.0!2d106.8324!3d-6.640886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c8b16ee07ef5%3A0x14ab253dd267de49!2sSMK%20Negeri%204%20Bogor%20(Nebrazka)!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan: Detail Kontak -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Kontak</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="contact-details">
                                        <h6 class="mb-1 fw-bold">Email</h6>
                                        <p class="mb-0 text-muted">smkn4@smkn4bogor.sch.id</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="contact-details">
                                        <h6 class="mb-1 fw-bold">Alamat</h6>
                                        <p class="mb-0 text-muted">Jl. Raya Tajur, Kp. Buntar RT.02/RW.08, Kel. Muara sari, Kec. Bogor Selatan, RT.03/RW.08, Muarasari, Kec. Bogor Sel., Kota Bogor, Jawa Barat 16137</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-phone text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="contact-details">
                                        <h6 class="mb-1 fw-bold">Telepon</h6>
                                        <p class="mb-0 text-muted">02517547381</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-fax text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="contact-details">
                                        <h6 class="mb-1 fw-bold">Fax</h6>
                                        <p class="mb-0 text-muted">(0251) 123457</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Kirim Pesan/Testimoni -->
            <div class="row mt-5">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Kirim Testimoni</h5>
                        </div>
                        <div class="card-body p-4">
                            @auth('user')
                                <!-- Form untuk user yang sudah login -->
                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Halo <strong>{{ Auth::guard('user')->user()->name ?? Auth::guard('user')->user()->username }}</strong>, kirimkan testimoni Anda!
                                </div>
                                
                                <form id="testimonialForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="pesan" class="form-label">Testimoni / Pesan</label>
                                        <textarea class="form-control" id="pesan" name="pesan" rows="5" placeholder="Tuliskan testimoni atau pesan Anda tentang SMKN 4 BOGOR..." required></textarea>
                                        <div class="form-text">Maksimal 1000 karakter</div>
                                    </div>
                                    
                                    <!-- reCAPTCHA (Optional) -->
                                    @if(config('services.recaptcha.site_key'))
                                    <div class="mb-4 d-flex justify-content-center">
                                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                    </div>
                                    @endif

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Testimoni
                                        </button>
                                    </div>
                                </form>
                                
                                <!-- Alert untuk feedback -->
                                <div id="alertContainer" class="mt-3"></div>
                            @else
                                <!-- Pesan untuk user yang belum login -->
                                <div class="text-center py-5">
                                    <i class="fas fa-lock fa-4x text-muted mb-4"></i>
                                    <h4 class="mb-3">Login Diperlukan</h4>
                                    <p class="text-muted mb-4">Anda harus login terlebih dahulu untuk mengirim testimoni.</p>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="{{ route('user.login') }}" class="btn btn-primary btn-lg px-4">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login
                                        </a>
                                        <a href="{{ route('user.register') }}" class="btn btn-outline-primary btn-lg px-4">
                                            <i class="fas fa-user-plus me-2"></i>Daftar
                                        </a>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Testimonial Form -->
    @auth('user')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('success', data.message);
                            testimonialForm.reset();
                            if (typeof grecaptcha !== 'undefined') { 
                                grecaptcha.reset(); 
                            }
                        } else {
                            // Handle validation errors
                            let errorMessage = data.message || 'Terjadi kesalahan';
                            
                            if (data.errors) {
                                const errors = Object.values(data.errors).flat();
                                errorMessage = errors.join('<br>');
                            }
                            
                            showAlert('danger', errorMessage);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('danger', 'Terjadi kesalahan saat mengirim testimoni. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Testimoni';
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
                
                // Scroll to alert
                alertContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                
                // Auto hide after 8 seconds
                setTimeout(() => {
                    const alert = alertContainer.querySelector('.alert');
                    if (alert) {
                        alert.remove();
                    }
                }, 8000);
            }
        });
    </script>
    @endauth
@endsection

