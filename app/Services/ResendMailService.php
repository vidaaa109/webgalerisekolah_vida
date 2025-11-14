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
            
            $fromName = config('mail.from.name', 'SMKN 4 BOGOR');
            $fromAddress = config('mail.from.address', 'noreply@resend.dev');
            
            // Remove quotes if present
            $fromAddress = trim($fromAddress, '"\'');
            $fromName = trim($fromName, '"\'');
            
            $from = $fromName . ' <' . $fromAddress . '>';
            
            Log::info('Attempting to send OTP email via Resend API', [
                'to' => $to,
                'from' => $from,
                'api_url' => $this->apiUrl
            ]);
            
            // Send email via Resend API directly using HTTP with timeout
            $response = Http::timeout(30)->withHeaders([
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
                    'from' => $from
                ]);
                return true;
            } else {
                Log::error('Resend API returned error', [
                    'to' => $to,
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'from' => $from
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email via Resend API', [
                'to' => $to,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
                'api_key_set' => !empty($this->apiKey)
            ]);
            return false;
        }
    }
}

