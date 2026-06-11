<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentRejected extends Notification
{
    use Queueable;

    public function __construct(
        public string $studentName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'payment_rejected',
            'title'        => 'Pembayaran Ditolak',
            'body'         => "Pembayaran untuk <strong>{$this->studentName}</strong> telah <strong>ditolak</strong> oleh Admin. Silakan periksa kembali bukti transfer Anda dan unggah ulang.",
            'student_name' => $this->studentName,
            'icon'         => 'fa-circle-xmark',
            'color'        => 'red',
            'link'         => null,
        ];
    }
}
