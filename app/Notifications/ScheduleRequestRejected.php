<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\WhatsappChannel;

class ScheduleRequestRejected extends Notification
{
    use Queueable;

    public function __construct(
        public string $studentName,
        public string $reason,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WhatsappChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'schedule_request_rejected',
            'title'        => 'Pindah Jadwal Ditolak ✗',
            'body'         => "Pengajuan pindah jadwal untuk murid <strong>{$this->studentName}</strong> telah <strong>ditolak</strong> oleh Admin. Alasan: <em>\"{$this->reason}\"</em>",
            'student_name' => $this->studentName,
            'icon'         => 'fa-circle-xmark',
            'color'        => 'red',
            'link'         => route('dashboard'),
        ];
    }

    public function toWhatsapp(object $notifiable): string
    {
        return "Halo Bapak/Ibu {$notifiable->name},\n\nPengajuan perpindahan jadwal latihan untuk murid *{$this->studentName}* ditolak oleh Admin.\n\nAlasan penolakan: \"{$this->reason}\"\n\nSilakan periksa kembali dashboard website untuk detail selengkapnya.";
    }
}
