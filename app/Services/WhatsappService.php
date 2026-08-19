<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Format nomor HP ke standar Fonnte (62...)
     */
    public static function formatNumber($number)
    {
        // Hapus karakter non-digit
        $number = preg_replace('/[^0-9]/', '', $number);

        // Jika diawali 62, biarkan
        if (str_starts_with($number, '62')) {
            return $number;
        }

        // Jika diawali 0, ganti dengan 62
        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        // Jika diawali 8 (langsung 812...), tambahkan 62
        if (str_starts_with($number, '8')) {
            return '62' . $number;
        }

        return $number;
    }

    /**
     * Kirim pesan WhatsApp melalui Fonnte
     * @param string $target
     * @param string $message
     * @param string $senderType 'finance' | 'operasional'
     */
    public static function send($target, $message, $senderType = 'operasional')
    {
        $token = match ($senderType) {
            'finance' => env('FONNTE_TOKEN_FINANCE') ?: env('FONNTE_TOKEN'),
            'operasional' => env('FONNTE_TOKEN_OPERASIONAL') ?: env('FONNTE_TOKEN'),
            default => env('FONNTE_TOKEN')
        };

        if (empty($token)) {
            Log::warning("WhatsApp Notification skipped: FONNTE_TOKEN ({$senderType}) is not set in .env");
            return false;
        }

        if (empty($target)) {
            Log::warning("WhatsApp Notification skipped: Recipient number (target) is empty.");
            return false;
        }

        $formattedTarget = self::formatNumber($target);

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->withoutVerifying()->post('https://api.fonnte.com/send', [
                'target' => $formattedTarget,
                'message' => $message,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp ({$senderType}) sent successfully to {$formattedTarget}");
                return true;
            } else {
                Log::error("WhatsApp ({$senderType}) send failed to {$formattedTarget}. Error: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp ({$senderType}) send exception to {$formattedTarget}: " . $e->getMessage());
            return false;
        }
    }
}
