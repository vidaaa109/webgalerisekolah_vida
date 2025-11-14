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

### Opsi 2: Verifikasi Email di Resend (Testing Mode - Sementara)

**PENTING**: Dalam mode testing, Resend hanya mengizinkan email yang sudah diverifikasi atau email milik Anda sendiri.

1. **Login ke Resend Dashboard**: https://resend.com/dashboard
2. **Pergi ke Emails/Logs**: Cek log untuk melihat email mana yang berhasil
3. **Verifikasi Email**: 
   - Resend biasanya mengizinkan email yang sudah pernah menerima email dari Resend sebelumnya
   - Atau email yang sudah diverifikasi di account Resend Anda
4. **Catatan**: Ini hanya solusi sementara untuk testing. Untuk production, **WAJIB** verifikasi domain sendiri.

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

- **Domain `noreply@resend.dev` adalah domain testing yang memiliki batasan**
- **Dalam mode testing, Resend hanya mengizinkan email tertentu** (seperti email yang sudah pernah menerima email dari Resend sebelumnya)
- Email `tanziljws@gmail.com` berhasil karena mungkin sudah pernah menerima email dari Resend sebelumnya
- **Untuk production, WAJIB verifikasi domain sendiri** agar bisa mengirim ke semua email
- Setelah verifikasi domain, Anda bisa mengirim ke email apapun tanpa batasan

## Solusi Cepat untuk Testing

Jika Anda perlu test dengan email lain sekarang juga:

1. **Gunakan email yang sama** (`tanziljws@gmail.com`) untuk testing
2. **Atau verifikasi domain sendiri** (Opsi 1) - ini solusi terbaik untuk production
3. **Atau upgrade ke paid plan** dan verifikasi domain

## Status Saat Ini

✅ **Email yang berhasil**: `tanziljws@gmail.com`  
❌ **Email lain**: Error 403 (Domain belum diverifikasi)  
🔧 **Solusi**: Verifikasi domain sendiri di Resend Dashboard

