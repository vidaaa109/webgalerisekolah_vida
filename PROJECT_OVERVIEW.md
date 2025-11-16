# 📚 Project Overview: Web Galeri Sekolah VIDA

## 🎯 Project Description

**Web Galeri Sekolah VIDA** is a Laravel-based school gallery website for SMKN 4 BOGOR. It's a comprehensive content management system that allows schools to showcase their activities, news, and photo galleries to the public, while providing administrative tools for content management.

---

## 🏗️ Architecture Overview

### **Technology Stack**
- **Framework**: Laravel 12.0
- **PHP Version**: ^8.2
- **Database**: MySQL/PostgreSQL (via Laravel migrations)
- **Frontend**: Blade templates with Bootstrap 5
- **Email Service**: Resend API (with BrevoMailService as alternative)
- **Authentication**: Multi-guard system (Admin, Petugas, User)

### **Project Structure**
```
webgalerisekolah_vida/
├── app/
│   ├── Console/Commands/        # Artisan commands
│   ├── Http/Controllers/        # Application controllers
│   │   ├── Admin/              # Admin panel controllers
│   │   └── Petugas/            # Staff panel controllers
│   ├── Mail/                   # Email classes
│   ├── Models/                 # Eloquent models
│   ├── Observers/              # Model observers (for counters)
│   ├── Providers/              # Service providers
│   └── Services/               # Business logic services
├── database/
│   ├── migrations/             # Database schema
│   └── seeders/               # Database seeders
├── resources/views/            # Blade templates
│   ├── guest/                 # Public pages
│   ├── admin/                 # Admin panel views
│   ├── petugas/               # Staff panel views
│   └── user/                  # User account views
├── routes/
│   ├── web.php                # Web routes
│   └── api.php                # API routes (with debug endpoints)
└── public/                    # Public assets
```

---

## 👥 User Roles & Authentication

### **1. Guest (Public Visitors)**
- **Access**: Public pages only
- **Features**:
  - View homepage with latest news
  - Browse school profile
  - View galleries and photos
  - Read agenda and information posts
  - Submit testimonials
  - Download photos (throttled: 30 requests/minute)

### **2. User (Registered Public Users)**
- **Guard**: `auth:user`
- **Model**: `App\Models\User`
- **Features**:
  - Register with email OTP verification
  - Login/Logout
  - Password reset via OTP
  - Like galleries
  - Bookmark galleries
  - Comment on galleries (with replies)
  - Download photos
  - Manage profile with photo upload

### **3. Petugas (Staff)**
- **Guard**: `auth:petugas`
- **Model**: `App\Models\Petugas`
- **Access**: Limited content management
- **Features**:
  - Manage Posts (CRUD)
  - Manage Galleries (CRUD)
  - Manage Photos (CRUD)
  - View dashboard with limited stats
- **Login**: `/petugas/login`

### **4. Admin (Administrator)**
- **Guard**: `auth:admin`
- **Model**: `App\Models\Admin`
- **Access**: Full system access
- **Features**:
  - All Petugas features
  - Manage Categories (CRUD)
  - Manage Petugas accounts (CRUD)
  - Edit school profile
  - Approve/Reject testimonials
  - View full dashboard statistics
- **Login**: `/admin/login`

---

## 📊 Database Schema

### **Core Models & Relationships**

#### **Posts (Berita/Artikel)**
- **Table**: `posts`
- **Fields**: `judul`, `kategori_id`, `isi`, `petugas_id`, `status`
- **Relationships**:
  - Belongs to `Kategori` (main category)
  - Belongs to many `Kategori` (additional categories via pivot)
  - Belongs to `Petugas` (author)
  - Has many `Galery` (galleries)

#### **Kategori (Categories)**
- **Table**: `kategori`
- **Fields**: `judul`
- **Key Categories**:
  - "Agenda" - School events
  - "Informasi Terkini" - Latest information
  - "Galeri Sekolah" - School galleries
- **Relationships**:
  - Has many `Post` (one-to-many)
  - Belongs to many `Post` (many-to-many via pivot)

#### **Galery (Photo Galleries)**
- **Table**: `galery`
- **Fields**: `judul`, `post_id`, `position`, `status`, `total_likes`, `total_comments`, `total_bookmarks`, `total_downloads`
- **Relationships**:
  - Belongs to `Post`
  - Has many `Foto`
  - Has many `Like`, `Bookmark`, `Comment`, `Download`

#### **Foto (Photos)**
- **Table**: `foto`
- **Fields**: `galery_id`, `file`
- **Storage**: `storage/app/public/fotos/`
- **Relationships**:
  - Belongs to `Galery`

#### **User Engagement Models**

1. **Like** (`likes` table)
   - `user_id`, `galery_id`
   - Tracks user likes on galleries

2. **Bookmark** (`bookmarks` table)
   - `user_id`, `galery_id`
   - Tracks user bookmarks

3. **Comment** (`comments` table)
   - `galery_id`, `user_id`, `parent_id`, `body`, `status`
   - Supports nested replies (parent-child relationship)
   - Soft deletes enabled

4. **Download** (`downloads` table)
   - Tracks photo downloads
   - Used for analytics

#### **Other Models**

- **Profile** (`profile` table): School profile information
- **Testimonial** (`testimonials` table): User testimonials with approval workflow
- **Admin** (`admins` table): Administrator accounts
- **Petugas** (`petugas` table): Staff accounts
- **User** (`users` table): Public user accounts with OTP fields

---

## 🛣️ Routes Structure

### **Public Routes (Guest)**
```
/                           → Homepage
/profil                     → School profile
/galeri                     → Gallery listing
/galeri/{galery}            → Gallery detail
/agenda                     → Agenda posts listing
/agenda/{post}              → Agenda post detail
/informasi                  → Information posts listing
/informasi/{post}           → Information post detail
/kontak                     → Contact page
```

### **User Routes (Authenticated)**
```
/user/register              → Registration form
/user/login                 → Login form
/user/otp                   → OTP verification
/user/profile               → User profile
/galleries/{galery}/like    → Toggle like (POST)
/galleries/{galery}/bookmark → Toggle bookmark (POST)
/galleries/{galery}/comments → Add comment (POST)
/comments/{comment}/reply   → Reply to comment (POST)
/galleries/{galery}/fotos/{foto}/download → Download photo
```

### **Admin Routes**
```
/admin/login                → Admin login
/admin                      → Admin dashboard
/admin/posts                → Posts management (CRUD)
/admin/kategori             → Categories management (CRUD)
/admin/galery               → Galleries management (CRUD)
/admin/foto                 → Photos management (CRUD)
/admin/petugas              → Staff management (CRUD)
/admin/profile              → School profile management
/admin/testimonials         → Testimonials approval
```

### **Petugas Routes**
```
/petugas/login              → Staff login
/petugas                    → Staff dashboard
/petugas/posts              → Posts management (CRUD)
/petugas/galery             → Galleries management (CRUD)
/petugas/foto               → Photos management (CRUD)
```

---

## 🔧 Key Features

### **1. Multi-Guard Authentication**
- Separate authentication systems for Admin, Petugas, and Users
- Each guard uses different models and tables
- Session-based authentication

### **2. OTP Email Verification**
- Users register with email
- OTP code sent via Resend API
- 10-minute expiration
- Resend functionality available
- Password reset also uses OTP

### **3. Content Management**
- **Posts**: Rich text content with categories
- **Galleries**: Photo collections linked to posts
- **Photos**: Image uploads with proper URL encoding
- **Categories**: Flexible categorization (one-to-many and many-to-many)

### **4. User Engagement**
- **Likes**: Users can like galleries
- **Bookmarks**: Save galleries for later
- **Comments**: Nested comment system with replies
- **Downloads**: Track photo downloads (throttled)

### **5. Observers & Counters**
- Model observers automatically update counters:
  - `total_likes`
  - `total_comments`
  - `total_bookmarks`
  - `total_downloads`
- Real-time counter updates without manual intervention

### **6. Testimonials System**
- Public users can submit testimonials
- Admin approval workflow (pending → approved/rejected)
- Only approved testimonials shown on homepage

### **7. File Management**
- Photos stored in `storage/app/public/fotos/`
- Proper URL encoding for filenames with special characters
- Storage link: `php artisan storage:link`

---

## 📧 Email Services

### **ResendMailService**
- Primary email service using Resend API
- Sends OTP codes for user verification
- Handles error cases (403, 422, 429)
- Detailed logging for debugging

### **BrevoMailService**
- Alternative email service (Brevo/Sendinblue)
- Fallback option if Resend fails

---

## 🎨 Frontend Structure

### **Layouts**
- `layouts/app.blade.php` - Public/guest layout
- `layouts/admin.blade.php` - Admin panel layout
- `layouts/petugas.blade.php` - Staff panel layout

### **Public Pages**
- `guest/home.blade.php` - Homepage with hero, news, testimonials
- `guest/profil.blade.php` - School profile
- `guest/galeri.blade.php` - Gallery listing
- `guest/galeri_show.blade.php` - Gallery detail with engagement
- `guest/agenda/` - Agenda posts pages
- `guest/informasi/` - Information posts pages

### **Admin Pages**
- `admin/dashboard.blade.php` - Statistics dashboard
- `admin/posts/` - Posts management
- `admin/kategori/` - Categories management
- `admin/galery/` - Galleries management
- `admin/foto/` - Photos management
- `admin/petugas/` - Staff management

---

## 🔐 Security Features

1. **Password Hashing**: All passwords hashed using bcrypt
2. **CSRF Protection**: Laravel CSRF tokens on all forms
3. **Rate Limiting**: Download throttling (30 requests/minute)
4. **Middleware Protection**: Routes protected by authentication middleware
5. **Input Validation**: Comprehensive validation on all forms
6. **SQL Injection Protection**: Eloquent ORM prevents SQL injection
7. **XSS Protection**: Blade templating escapes output by default

---

## 📝 Configuration Files

### **Auth Configuration** (`config/auth.php`)
- Multiple guards: `web`, `user`, `admin`, `petugas`
- Multiple providers: `users`, `admins`, `petugas`
- Separate password reset configurations

### **Mail Configuration** (`config/mail.php`)
- Resend API integration
- Configurable from address and name

### **Services Configuration** (`config/services.php`)
- Resend API key configuration
- Brevo API key configuration

---

## 🚀 Setup & Installation

### **Prerequisites**
- PHP 8.2+
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (for frontend assets)

### **Installation Steps**
1. Clone repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env`
4. Generate app key: `php artisan key:generate`
5. Configure database in `.env`
6. Run migrations: `php artisan migrate`
7. Run seeders: `php artisan db:seed`
8. Create storage link: `php artisan storage:link`
9. Configure email service (Resend API key)
10. Start server: `php artisan serve`

### **Default Credentials**
- **Admin**: username: `admin`, password: `admin123`
- **Petugas**: Created by admin via admin panel

---

## 📈 Key Statistics Tracked

### **Dashboard Metrics**
- Total Posts
- Total Galleries
- Total Photos
- Total Petugas
- Total Users
- Total Testimonials (pending/approved)

### **Gallery Metrics**
- Total likes
- Total comments
- Total bookmarks
- Total downloads

---

## 🔄 Workflows

### **User Registration Flow**
1. User fills registration form
2. System validates input
3. User account created (unverified)
4. OTP generated and saved
5. OTP email sent via Resend
6. User enters OTP on verification page
7. Account verified, user logged in

### **Content Publishing Flow**
1. Petugas/Admin creates post
2. Post assigned to category
3. Gallery created and linked to post
4. Photos uploaded to gallery
5. Gallery published (status = 1)
6. Appears on public gallery page

### **Testimonial Approval Flow**
1. User submits testimonial
2. Status set to "pending"
3. Admin reviews in admin panel
4. Admin approves or rejects
5. Approved testimonials appear on homepage

---

## 🐛 Debug Features

### **API Debug Routes** (`routes/api.php`)
- `/api/debug/galery` - List all galleries
- `/api/debug/foto` - List all photos
- `/api/debug/petugas` - List all staff
- `/api/debug/petugas/{id}` - Get specific staff member
- `/api/test-foto` - Test photo creation endpoint

---

## 📚 Documentation Files

- `README.md` - Laravel framework documentation
- `README_WEBSITE.md` - Website structure documentation
- `PANDUAN_ADMIN_PETUGAS.md` - Admin & Petugas guide
- `RESEND_EMAIL_SETUP.md` - Email service setup
- `BREVO_SIMPLE_SETUP.md` - Brevo email setup
- `SMTP_CONFIG.md` - SMTP configuration guide

---

## 🎯 Future Enhancements (Potential)

1. **Search Functionality**: Search posts, galleries, photos
2. **Pagination**: Better pagination for large datasets
3. **Image Optimization**: Automatic image compression
4. **Social Sharing**: Share galleries on social media
5. **Notifications**: Email notifications for new content
6. **Analytics**: Detailed visitor analytics
7. **Multi-language**: Support for multiple languages
8. **API Documentation**: Swagger/OpenAPI documentation
9. **Caching**: Redis/Memcached for performance
10. **Queue System**: Background job processing for emails

---

## 📞 Support & Maintenance

### **Common Issues**
1. **Storage Link**: Run `php artisan storage:link` if images don't load
2. **Email Not Sending**: Check Resend API key in `.env`
3. **Permission Errors**: Set proper file permissions (755 for directories)
4. **Cache Issues**: Clear cache with `php artisan cache:clear`

### **Logs**
- Application logs: `storage/logs/laravel.log`
- Email service logs: Check Laravel log for Resend API errors

---

## ✅ Project Status

**Current Version**: Production-ready
**Laravel Version**: 12.0
**PHP Version**: 8.2+
**Status**: Active development/maintenance

---

*Last Updated: Based on current codebase analysis*

