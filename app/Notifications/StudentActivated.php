<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\WhatsappChannel;

class StudentActivated extends Notification
{
    use Queueable;

    public string $senderType = 'operasional';

    public function __construct(
        public string $studentName,
        public string $startDateStr,
        public string $endDateStr,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WhatsappChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'student_activated',
            'title'        => 'Paket Latihan Aktif 🏊',
            'body'         => "Paket latihan untuk <strong>{$this->studentName}</strong> telah diaktifkan per tanggal <strong>{$this->startDateStr}</strong> (berlaku s/d <strong>{$this->endDateStr}</strong>). Selamat berlatih!",
            'student_name' => $this->studentName,
            'icon'         => 'fa-calendar-check',
            'color'        => 'green',
            'link'         => null,
        ];
    }

    public function toWhatsapp(object $notifiable): string
    {
        return "Halo Bapak/Ibu {$notifiable->name},\n\nPaket latihan untuk *{$this->studentName}* telah resmi *DIAKTIFKAN* oleh Admin Operasional!\n\n📅 *Mulai Latihan*: {$this->startDateStr}\n⏳ *Berlaku Sampai*: {$this->endDateStr}\n\nSelamat berlatih di Black Diamond Swim Academy! 🏊";
    }
}
