<?php

namespace App\Notifications;

use App\Models\CoachLeave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CoachLeaveRejected extends Notification
{
    use Queueable;

    public function __construct(
        public CoachLeave $leave,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $formattedDate = $this->leave->leave_date->format('d M Y');
        return [
            'type'         => 'coach_leave_rejected',
            'title'        => 'Izin Latihan Ditolak ✗',
            'body'         => "Pengajuan izin latihan Anda untuk tanggal <strong>{$formattedDate}</strong> telah <strong>ditolak</strong> oleh Admin dengan alasan: \"{$this->leave->rejection_reason}\".",
            'leave_id'     => $this->leave->id,
            'icon'         => 'fa-circle-xmark',
            'color'        => 'red',
            'link'         => route('coach.leaves.index'),
        ];
    }
}
