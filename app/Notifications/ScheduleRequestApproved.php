<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ScheduleRequestApproved extends Notification
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
            'type'         => 'schedule_request_approved',
            'title'        => 'Pindah Jadwal Disetujui ✓',
            'body'         => "Pengajuan pindah jadwal untuk murid <strong>{$this->studentName}</strong> telah <strong>disetujui</strong> oleh Admin. Silakan periksa dashboard untuk melihat jadwal aktif terbaru.",
            'student_name' => $this->studentName,
            'icon'         => 'fa-circle-check',
            'color'        => 'green',
            'link'         => route('dashboard'),
        ];
    }
}
