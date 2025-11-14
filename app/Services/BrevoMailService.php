<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;

class BrevoMailService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.brevo.com/v3/smtp/email';

    public function __construct()
    {
        $this->apiKey = config('services.brevo.key');
        if (!$this->apiKey) {
            throw new \Exception('Brevo API key not configured');
        }
    }

    /**
     * Send OTP email via Brevo API
     */
    public function sendOtpEmail(string $to, string $otp): bool
    {
        try {
            $html = View::make('emails.otp', ['otp' => $otp])->render();
            
            $fromName = config('mail.from.name', 'SMKN 4 BOGOR');
            $fromAddress = config('mail.from.address', 'noreply@brevo.com');
            
            // Remove quotes if present
            $fromAddress = trim($fromAddress, '"\'');
            $fromName = trim($fromName, '"\'');

            Log::info('Attempting to send OTP email via Brevo API', [
                'to' => $to,
                'from' => $fromAddress,
                'from_name' => $fromName,
                'api_url' => $this->apiUrl
            ]);

            // Send email via Brevo API
            $response = Http::timeout(30)->withHeaders([
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->apiUrl, [
                'sender' => [
                    'name' => $fromName,
                    'email' => $fromAddress,
                ],
                'to' => [
                    [
                        'email' => $to,
                    ]
                ],
                'subject' => 'Kode OTP Verifikasi Akun Anda',
                'htmlContent' => $html,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('OTP email sent successfully via Brevo API', [
                    'to' => $to,
                    'message_id' => $result['messageId'] ?? null,
                    'from' => $fromAddress
                ]);
                return true;
            } else {
                $errorBody = $response->json();
                $errorMessage = $errorBody['message'] ?? $response->body();
                $statusCode = $response->status();
                
                Log::error('Brevo API returned error', [
                    'to' => $to,
                    'status' => $statusCode,
                    'error_message' => $errorMessage,
                    'full_response' => $errorBody,
                    'from' => $fromAddress
                ]);
                
                // Throw exception with detailed error
                throw new \Exception("Brevo API Error ({$statusCode}): {$errorMessage}");
            }
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email via Brevo API', [
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

