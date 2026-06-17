<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ScheduleRequestRejected extends Notification
{
    use Queueable;

    public function __construct(
        public string $studentName,
        public string $reason,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
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
}
