# Panduan Setup Resend Email di Laravel

## 1. Install Package Resend PHP SDK

```bash
composer require resend/resend-php
```

## 2. Setup Environment Variables (.env)

Tambahkan konfigurasi berikut di file `.env`:

```env
# Resend Email Configuration
MAIL_MAILER=resend
RESEND_KEY=re_your_api_key_here
MAIL_FROM_ADDRESS="noreply@resend.dev"
MAIL_FROM_NAME="Your App Name"
```

**Catatan:**
- `RESEND_KEY`: Dapatkan dari https://resend.com/api-keys
- `MAIL_FROM_ADDRESS`: Untuk testing bisa pakai `noreply@resend.dev`, untuk production harus verify domain dulu
- `MAIL_FROM_NAME`: Nama yang akan muncul sebagai pengirim

## 3. Update config/services.php

Pastikan ada konfigurasi Resend:

```php
'resend' => [
    'key' => env('RESEND_KEY'),
],
```

## 4. Buat ResendMailService

Buat file `app/Services/ResendMailService.php`:

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;

class ResendMailService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.resend.com/emails';

    public function __construct()
    {
        $this->apiKey = config('services.resend.key');
        if (!$this->apiKey) {
            throw new \Exception('Resend API key not configured');
        }
    }

    /**
     * Send OTP email
     */
    public function sendOtpEmail(string $to, string $otp): bool
    {
        try {
            $html = View::make('emails.otp', ['otp' => $otp])->render();
            
            $fromName = config('mail.from.name', 'Your App Name');
            $fromAddress = config('mail.from.address', 'noreply@resend.dev');
            
            // Remove quotes if present
            $fromAddress = trim($fromAddress, '"\'');
            $fromName = trim($fromName, '"\'');
            
            $from = $fromName . ' <' . $fromAddress . '>';
            
            Log::info('Attempting to send OTP email via Resend API', [
                'to' => $to,
                'from' => $from,
            ]);
            
            // Send email via Resend API directly using HTTP
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'from' => $from,
                'to' => [$to],
                'subject' => 'Kode OTP Verifikasi Akun Anda',
                'html' => $html,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('OTP email sent successfully via Resend API', [
                    'to' => $to,
                    'resend_id' => $result['id'] ?? null,
                ]);
                return true;
            } else {
                Log::error('Resend API returned error', [
                    'to' => $to,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email via Resend API', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send custom email
     * 
     * @param string $to Email penerima
     * @param string $subject Subject email
     * @param string $viewName Nama view (contoh: 'emails.welcome')
     * @param array $data Data untuk view
     * @return bool
     */
    public function sendEmail(string $to, string $subject, string $viewName, array $data = []): bool
    {
        try {
            $html = View::make($viewName, $data)->render();
            
            $fromName = config('mail.from.name', 'Your App Name');
            $fromAddress = config('mail.from.address', 'noreply@resend.dev');
            
            $fromAddress = trim($fromAddress, '"\'');
            $fromName = trim($fromName, '"\'');
            
            $from = $fromName . ' <' . $fromAddress . '>';
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'from' => $from,
                'to' => [$to],
                'subject' => $subject,
                'html' => $html,
            ]);

            if ($response->successful()) {
                Log::info('Email sent successfully via Resend API', [
                    'to' => $to,
                    'subject' => $subject,
                    'resend_id' => $response->json()['id'] ?? null,
                ]);
                return true;
            } else {
                Log::error('Resend API returned error', [
                    'to' => $to,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Failed to send email via Resend API', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
```

## 5. Cara Menggunakan di Controller

### Contoh 1: Kirim OTP Email

```php
use App\Services\ResendMailService;

public function sendOtp(Request $request)
{
    $user = User::find($request->user_id);
    $otp = '123456'; // Generate OTP
    
    try {
        $resendService = new ResendMailService();
        $sent = $resendService->sendOtpEmail($user->email, $otp);
        
        if ($sent) {
            return response()->json(['message' => 'OTP sent successfully']);
        } else {
            return response()->json(['error' => 'Failed to send OTP'], 500);
        }
    } catch (\Exception $e) {
        Log::error('Error sending OTP: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to send OTP'], 500);
    }
}
```

### Contoh 2: Kirim Email Custom

```php
use App\Services\ResendMailService;

public function sendWelcomeEmail(User $user)
{
    try {
        $resendService = new ResendMailService();
        $sent = $resendService->sendEmail(
            to: $user->email,
            subject: 'Selamat Datang!',
            viewName: 'emails.welcome',
            data: ['user' => $user]
        );
        
        if ($sent) {
            return 'Email sent!';
        }
    } catch (\Exception $e) {
        Log::error('Error: ' . $e->getMessage());
    }
}
```

## 6. Buat Email View Template

Buat file `resources/views/emails/otp.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Verifikasi</title>
</head>
<body>
    <p>Halo,</p>
    <p>Berikut adalah kode OTP Anda untuk verifikasi akun:</p>
    <h2 style="letter-spacing:4px;">{{ $otp }}</h2>
    <p>Kode ini berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun.</p>
    <p>Terima kasih.</p>
</body>
</html>
```

## 7. Keuntungan Menggunakan Resend API

✅ **Tidak blocking** - Request tidak menunggu email terkirim
✅ **Reliable** - Resend memiliki deliverability tinggi
✅ **Simple** - Tidak perlu setup SMTP yang kompleks
✅ **Free tier** - 3,000 email/bulan gratis
✅ **Fast** - Email terkirim dalam hitungan detik
✅ **No queue needed** - Bisa langsung kirim tanpa queue worker

## 8. Troubleshooting

### Email tidak terkirim?

1. **Cek API Key**
   ```bash
   # Pastikan di .env
   RESEND_KEY=re_your_key_here
   ```

2. **Cek Log**
   ```bash
   tail -f storage/logs/laravel.log | grep -i resend
   ```

3. **Test API Key**
   - Login ke https://resend.com
   - Cek API keys di dashboard
   - Pastikan key masih aktif

4. **Cek Domain**
   - Untuk production, verify domain dulu di Resend
   - Untuk testing, bisa pakai `noreply@resend.dev`

### Error "Invalid API Key"?

- Pastikan API key benar di `.env`
- Pastikan tidak ada spasi atau karakter aneh
- Clear config cache: `php artisan config:clear`

### Email masuk spam?

- Verify domain di Resend
- Setup SPF, DKIM, dan DMARC records
- Gunakan domain yang sudah verified

## 9. Alternatif: Menggunakan Resend SDK (Jika autoload bekerja)

Jika Resend SDK terautoload dengan benar, bisa pakai cara ini:

```php
use Resend;

$resend = Resend::client('re_your_api_key');

$result = $resend->emails->send([
    'from' => 'Acme <onboarding@resend.dev>',
    'to' => ['delivered@resend.dev'],
    'subject' => 'Hello World',
    'html' => '<strong>It works!</strong>',
]);
```

Tapi cara HTTP client langsung (seperti di service) lebih reliable karena tidak bergantung pada autoload package.

## 10. Best Practices

1. **Selalu gunakan try-catch** untuk error handling
2. **Log semua error** untuk debugging
3. **Jangan hardcode API key** - selalu pakai environment variable
4. **Verify domain** untuk production
5. **Test dulu** dengan email test sebelum production
6. **Monitor log** untuk tracking email yang terkirim

## 11. Contoh Lengkap di Controller

```php
<?php

namespace App\Http\Controllers;

use App\Services\ResendMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        try {
            $resendService = new ResendMailService();
            $sent = $resendService->sendOtpEmail($request->email, $otp);
            
            if ($sent) {
                // Simpan OTP ke database
                // ...
                
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error sending OTP: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
```

---

**Selesai!** Sekarang Anda bisa menggunakan Resend untuk mengirim email di project Laravel lainnya. 🚀


