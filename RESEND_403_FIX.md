# Cara Mengatasi Error 403 di Resend API

## Masalah
Sebagian besar request ke Resend API mendapatkan status `403 Forbidden`, hanya beberapa email yang berhasil (seperti `tanziljws@gmail.com`).

## Penyebab
1. **Domain belum diverifikasi**: Domain `noreply@resend.dev` adalah domain testing Resend yang memiliki batasan
2. **Mode Testing**: Dalam mode testing, Resend hanya mengizinkan email tertentu
3. **Email tidak diizinkan**: Beberapa email mungkin tidak diizinkan dalam mode testing

## Solusi

### Opsi 1: Verifikasi Domain Sendiri (Recommended untuk Production)

1. **Login ke Resend Dashboard**: https://resend.com/dashboard
2. **Pergi ke Domains**: Klik menu "Domains" di sidebar
3. **Add Domain**: Klik "Add Domain" dan masukkan domain Anda (contoh: `yourdomain.com`)
4. **Verifikasi Domain**: Ikuti instruksi untuk menambahkan DNS records:
   - SPF record
   - DKIM records
   - DMARC record (optional)
5. **Update .env**: Setelah domain diverifikasi, update `.env`:
   ```env
   MAIL_FROM_ADDRESS="noreply@yourdomain.com"
   MAIL_FROM_NAME="SMKN 4 BOGOR"
   ```

### Opsi 2: Tambahkan Email ke Allowed List (Testing Mode)

Jika masih dalam mode testing dan hanya ingin menambahkan beberapa email:

1. **Login ke Resend Dashboard**: https://resend.com/dashboard
2. **Pergi ke Settings**: Klik menu "Settings"
3. **API Keys**: Pastikan API key memiliki permission "Full Access" atau "Sending Access"
4. **Check Logs**: Cek log di dashboard untuk melihat detail error 403

### Opsi 3: Upgrade Account

Jika account masih dalam mode free/testing:
1. **Upgrade Account**: Upgrade ke paid plan untuk menghilangkan batasan
2. **Verify Domain**: Setelah upgrade, verifikasi domain sendiri

## Error Handling yang Sudah Diperbaiki

Kode sekarang sudah menangani error 403 dengan lebih baik:
- Menampilkan pesan error yang lebih informatif
- Logging detail error untuk debugging
- Menangani berbagai jenis error (403, 422, 429)

## Testing

Setelah memperbaiki masalah domain/email:
1. Coba kirim email ke berbagai alamat email
2. Cek log di `storage/logs/laravel.log` untuk detail error
3. Cek Resend dashboard logs untuk melihat status pengiriman

## Catatan Penting

- Domain `noreply@resend.dev` adalah domain testing yang memiliki batasan
- Untuk production, **WAJIB** verifikasi domain sendiri
- Email yang berhasil (seperti `tanziljws@gmail.com`) mungkin sudah ditambahkan ke allowed list sebelumnya

