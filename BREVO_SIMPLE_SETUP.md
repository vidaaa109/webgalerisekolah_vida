# Setup Brevo Tanpa Verifikasi Domain

## Cara Mudah - Gunakan Email yang Sudah Diverifikasi

Brevo mengizinkan pengiriman email tanpa verifikasi domain, asalkan menggunakan **email yang sudah diverifikasi** di akun Brevo Anda.

## Langkah Setup

### 1. Cek Email yang Sudah Diverifikasi di Brevo

1. **Login ke Brevo Dashboard**: https://app.brevo.com/
2. **Pergi ke Senders & IP** → **Senders**
3. **Lihat daftar email yang sudah diverifikasi** (biasanya email login Anda atau email yang sudah ditambahkan sebelumnya)

### 2. Update .env dengan Email yang Sudah Diverifikasi

Gunakan email yang sudah diverifikasi di Brevo (biasanya email login Anda):

```env
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="SMKN 4 BOGOR"
BREVO_API_KEY=your-brevo-api-key-here
```

**Contoh:**
- Jika email login Brevo Anda adalah `tanziljws@gmail.com`, gunakan itu
- Atau email lain yang sudah diverifikasi di Brevo

### 3. Jika Email Belum Diverifikasi

Jika email belum diverifikasi:

1. **Pergi ke Senders & IP** → **Senders**
2. **Klik "Add a sender"**
3. **Masukkan email Anda** (contoh: `your-email@gmail.com`)
4. **Verifikasi email** dengan klik link yang dikirim ke email tersebut
5. **Setelah diverifikasi**, gunakan email tersebut di `.env`

## Catatan Penting

- ✅ **TIDAK PERLU** verifikasi domain untuk testing
- ✅ Cukup gunakan email yang sudah diverifikasi di Brevo
- ✅ Email login Brevo biasanya sudah otomatis diverifikasi
- ❌ Jangan gunakan `noreply@brevo.com` - itu bukan email valid

## Testing

Setelah update `.env`:
1. Clear config cache: `php artisan config:clear`
2. Test dengan register atau reset password
3. Cek email inbox (dan spam folder)

## Troubleshooting

### Email tidak terkirim
- Pastikan `MAIL_FROM_ADDRESS` menggunakan email yang sudah diverifikasi di Brevo
- Cek log di `storage/logs/laravel.log` untuk detail error
- Pastikan API key benar dan memiliki permission

### Error "Invalid sender"
- Email di `MAIL_FROM_ADDRESS` belum diverifikasi di Brevo
- Verifikasi email di Brevo dashboard terlebih dahulu

