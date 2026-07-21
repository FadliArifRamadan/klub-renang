<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\WhatsappChannel;

class ScheduleRequestApproved extends Notification
{
    use Queueable;

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
            'type'         => 'schedule_request_approved',
            'title'        => 'Pindah Jadwal Disetujui ✓',
            'body'         => "Pengajuan pindah jadwal untuk murid <strong>{$this->studentName}</strong> telah <strong>disetujui</strong> oleh Admin. Silakan periksa dashboard untuk melihat jadwal aktif terbaru.",
            'student_name' => $this->studentName,
            'icon'         => 'fa-circle-check',
            'color'        => 'green',
            'link'         => route('dashboard'),
        ];
    }

    public function toWhatsapp(object $notifiable): string
    {
        return "Halo Bapak/Ibu {$notifiable->name},\n\nPengajuan perpindahan jadwal latihan untuk murid *{$this->studentName}* telah *DISETUJUI* oleh Admin.\n\nSilakan periksa dashboard website untuk melihat jadwal aktif terbaru anak Anda. Terima kasih! 🏊";
    }
}
