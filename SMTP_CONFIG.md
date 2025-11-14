# Konfigurasi SMTP

## Status
✅ **MAIL_MAILER** sudah diubah ke `smtp`
✅ **UserAuthController** sudah menggunakan `Mail::send()` dengan `OtpCodeMail`

## Konfigurasi SMTP yang Diperlukan

Tambahkan konfigurasi berikut ke file `.env`:

### Untuk Gmail SMTP:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="SMKN 4 BOGOR"
```

**Catatan untuk Gmail:**
- Gunakan **App Password**, bukan password biasa
- Aktifkan 2-Step Verification di Gmail
- Generate App Password: https://myaccount.google.com/apppasswords

### Untuk SMTP Lainnya (Contoh: Mailtrap untuk Testing):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="SMKN 4 BOGOR"
```

### Untuk SMTP Server Sendiri:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="SMKN 4 BOGOR"
```

## Setelah Konfigurasi

1. **Update `.env`** dengan konfigurasi SMTP yang sesuai
2. **Clear config cache**: `php artisan config:clear`
3. **Test email**: Coba register atau reset password untuk test pengiriman email

## Catatan

- Pastikan port SMTP tidak diblokir oleh firewall
- Untuk Railway, pastikan SMTP port (587/465) tidak diblokir
- Jika Railway memblokir SMTP, pertimbangkan menggunakan service email seperti:
  - SendGrid
  - Mailgun
  - Postmark
  - Atau kembali ke Resend dengan domain yang sudah diverifikasi

