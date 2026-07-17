<?php

namespace App\Notifications;

use App\Models\CoachLeave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CoachLeaveApproved extends Notification
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
        $substituteText = $this->leave->substituteCoach 
            ? "dengan pelatih pengganti <strong>{$this->leave->substituteCoach->name}</strong>" 
            : "dan latihan pada hari tersebut diliburkan";

        return [
            'type'         => 'coach_leave_approved',
            'title'        => 'Izin Latihan Disetujui ✓',
            'body'         => "Pengajuan izin latihan Anda untuk tanggal <strong>{$formattedDate}</strong> telah <strong>disetujui</strong> oleh Admin {$substituteText}.",
            'leave_id'     => $this->leave->id,
            'icon'         => 'fa-circle-check',
            'color'        => 'green',
            'link'         => route('coach.leaves.index'),
        ];
    }
}
