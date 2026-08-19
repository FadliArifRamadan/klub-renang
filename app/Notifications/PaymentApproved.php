<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\WhatsappChannel;

class PaymentApproved extends Notification
{
    use Queueable;

    public string $senderType = 'finance';

    public function __construct(
        public string $studentName,
        public string $coachName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WhatsappChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'payment_approved',
            'title'        => 'Pembayaran Disetujui ✓',
            'body'         => "Pembayaran untuk <strong>{$this->studentName}</strong> telah <strong>disetujui</strong> oleh Admin. Pelatih yang ditetapkan: <strong>{$this->coachName}</strong>. Selamat berlatih!",
            'student_name' => $this->studentName,
            'icon'         => 'fa-circle-check',
            'color'        => 'green',
            'link'         => null,
        ];
    }

    public function toWhatsapp(object $notifiable): string
    {
        return "Halo Bapak/Ibu {$notifiable->name},\n\nPembayaran pendaftaran/perpanjangan untuk *{$this->studentName}* telah *DISETUJUI* oleh Admin.\n\nPelatih yang ditetapkan: *{$this->coachName}*.\n\nSelamat berlatih! 🏊";
    }
}
