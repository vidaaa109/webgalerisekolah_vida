<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\GaleryController;
use App\Http\Controllers\Admin\FotoController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\GaleryInteractionController;
use App\Http\Controllers\Admin\CommentModerationController;
use App\Http\Controllers\Admin\ReportExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Guest Routes (Public)
Route::get('/', [GuestController::class, 'home'])->name('guest.home');
Route::get('/profil', [GuestController::class, 'profil'])->name('guest.profil');

// Agenda (Posts dengan kategori "Agenda")
Route::get('/agenda', [GuestController::class, 'agenda'])->name('guest.agenda');
Route::get('/agenda/{post}', [GuestController::class, 'agendaShow'])->name('guest.agenda.show');

// Informasi (Posts dengan kategori "Informasi Terkini")
Route::get('/informasi', [GuestController::class, 'informasi'])->name('guest.informasi');
Route::get('/informasi/{post}', [GuestController::class, 'informasiShow'])->name('guest.informasi.show');

// Galeri (tetap ada + akan tampilkan posts dengan kategori "Galeri Sekolah")
Route::get('/galeri', [GuestController::class, 'galeri'])->name('guest.galeri');
Route::get('/galeri/{galery}', [GuestController::class, 'galeriShow'])->name('guest.galeri.show');

// Kontak
Route::get('/kontak', [GuestController::class, 'kontak'])->name('guest.kontak');

// Engagement Routes
// Public download (bebas), dengan throttle untuk membatasi penyalahgunaan
Route::middleware('throttle:30,1')->group(function () {
    Route::get('/galleries/{galery}/fotos/{foto}/download', [DownloadController::class, 'download'])
        ->name('galleries.fotos.download');
});

// Aksi yang membutuhkan login user
Route::middleware(['auth:user', 'ensure.user.active'])->group(function () {
    Route::post('/galleries/{galery}/like', [LikeController::class, 'toggle'])->name('galleries.like');
    Route::post('/galleries/{galery}/bookmark', [BookmarkController::class, 'toggle'])->name('galleries.bookmark');
    Route::post('/galleries/{galery}/comments', [CommentController::class, 'store'])->name('galleries.comments.store');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

// Testimonial Routes: submission requires authenticated user
Route::post('/testimonial', [TestimonialController::class, 'store'])->middleware('auth:user')->name('testimonial.store');
Route::get('/testimonials/approved', [TestimonialController::class, 'getApproved'])->name('testimonials.approved');

// User Auth (Public user) Routes
Route::prefix('user')->name('user.')->group(function () {
    // Register & OTP
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::get('/otp', [UserAuthController::class, 'showOtpForm'])->name('otp');
    Route::post('/otp/verify', [UserAuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/otp/resend', [UserAuthController::class, 'resendOtp'])->name('otp.resend');

    // Login/Logout untuk user
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    // Forgot Password
    Route::get('/forgot-password', [UserAuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [UserAuthController::class, 'sendResetOtp']);
    Route::get('/reset-password-otp', [UserAuthController::class, 'showResetPasswordOtpForm'])->name('reset-password-otp');
    Route::post('/reset-password-otp/verify', [UserAuthController::class, 'verifyResetOtp'])->name('reset-password-otp.verify');
    Route::post('/reset-password-otp/resend', [UserAuthController::class, 'resendResetOtp'])->name('reset-password-otp.resend');
    Route::get('/reset-password', [UserAuthController::class, 'showResetPasswordForm'])->name('reset-password-form');
    Route::post('/reset-password', [UserAuthController::class, 'resetPassword'])->name('reset-password');

    // Profil (butuh login user)
    Route::middleware(['auth:user', 'ensure.user.active'])->group(function () {
        Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    });
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes (Protected)
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/pdf', [AdminController::class, 'exportDashboardPdf'])->name('dashboard.pdf');
    
    // Posts Management
    Route::resource('posts', PostController::class);
    
    // Kategori Management
    Route::resource('kategori', KategoriController::class);
    
    // Galeri Management
    Route::resource('galery', GaleryController::class);
    Route::get('galery/{galery}/interactions', [GaleryInteractionController::class, 'show'])->name('galery.interactions');
    Route::get('galery/{galery}/interactions/pdf', [GaleryInteractionController::class, 'exportPdf'])->name('galery.interactions.pdf');
    
    // Foto Management
    Route::resource('foto', FotoController::class);
    
    // Petugas Management
    Route::resource('petugas', PetugasController::class);
    
    // Profile Management
    Route::resource('profile', ProfileController::class);

    // User Management
    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('users.updateStatus');
    
    // Testimonial Management
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::put('/testimonials/{id}/status', [TestimonialController::class, 'updateStatus'])->name('testimonials.updateStatus');
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Reports
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::patch('reports/{report}', [\App\Http\Controllers\Admin\ReportController::class, 'update'])->name('reports.update');
    Route::get('reports/export', [ReportExportController::class, 'index'])->name('reports.export.form');
    Route::get('reports/export/download', [ReportExportController::class, 'export'])->name('reports.export.download');
    Route::get('reports/export/pdf', [ReportExportController::class, 'exportPdf'])->name('reports.export.pdf');

    // Comment moderation
    Route::patch('comments/{comment}/status', [CommentModerationController::class, 'updateStatus'])->name('comments.updateStatus');
    Route::delete('comments/{comment}', [CommentModerationController::class, 'destroy'])->name('comments.destroy');
});

// Petugas Routes (Staff Panel)
Route::prefix('petugas')->name('petugas.')->group(function () {
    // Auth routes
    Route::get('/login', [App\Http\Controllers\PetugasAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\PetugasAuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\PetugasAuthController::class, 'logout'])->name('logout');
    
    // Protected routes
    Route::middleware(['auth:petugas'])->group(function () {
        Route::get('/', [App\Http\Controllers\PetugasDashboardController::class, 'dashboard'])->name('dashboard');
        
        // Posts Management
        Route::resource('posts', App\Http\Controllers\Petugas\PostController::class);
        
        // Galeri Management
        Route::resource('galery', App\Http\Controllers\Petugas\GaleryController::class);
        
        // Foto Management
        Route::resource('foto', App\Http\Controllers\Petugas\FotoController::class);
    });
});
