<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\WhatsappChannel;

class PaymentRejected extends Notification
{
    use Queueable;

    public string $senderType = 'finance';

    public function __construct(
        public string $studentName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WhatsappChannel::class];
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

    public function toWhatsapp(object $notifiable): string
    {
        return "Halo Bapak/Ibu {$notifiable->name},\n\nPembayaran pendaftaran/perpanjangan untuk *{$this->studentName}* telah *DITOLAK* oleh Admin.\n\nSilakan periksa kembali bukti transfer Anda di dashboard website dan lakukan unggah ulang bukti pembayaran yang valid.";
    }
}
