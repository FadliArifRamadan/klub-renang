<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Services\WhatsappService;

class WhatsappChannel
{
    /**
     * Kirim notifikasi melalui WhatsApp.
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsapp')) {
            return;
        }

        // Ambil nomor telepon dari user/notifiable
        $phone = $notifiable->phone ?? null;
        if (empty($phone)) {
            return;
        }

        $message = $notification->toWhatsapp($notifiable);
        if (empty($message)) {
            return;
        }

        // Deteksi senderType dari kelas notifikasi (default: 'operasional')
        $senderType = property_exists($notification, 'senderType') ? $notification->senderType : 'operasional';

        WhatsappService::send($phone, $message, $senderType);
    }
}
