<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\WhatsappChannel;

class ScheduleRequestSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public string $studentName,
        public string $requesterName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WhatsappChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'schedule_request_submitted',
            'title'        => 'Pengajuan Pindah Jadwal Baru',
            'body'         => "<strong>{$this->requesterName}</strong> mengajukan perpindahan jadwal latihan untuk murid <strong>{$this->studentName}</strong>.",
            'student_name' => $this->studentName,
            'icon'         => 'fa-calendar-plus',
            'color'        => 'amber',
            'link'         => route('admin.schedule-requests.index'),
        ];
    }

    public function toWhatsapp(object $notifiable): string
    {
        return "Notifikasi Admin:\n\n*{$this->requesterName}* mengajukan perpindahan jadwal latihan baru untuk murid *{$this->studentName}*.\n\nMohon periksa dan proses pengajuan perpindahan jadwal ini di dashboard Admin.";
    }
}
