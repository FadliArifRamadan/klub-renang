<?php

namespace App\Notifications;

use App\Models\CoachLeave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\WhatsappChannel;

class CoachLeaveSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public CoachLeave $leave,
        public string $coachName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WhatsappChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        $formattedDate = $this->leave->leave_date->format('d M Y');
        return [
            'type'         => 'coach_leave_submitted',
            'title'        => 'Pengajuan Izin Coach ✉',
            'body'         => "Coach <strong>{$this->coachName}</strong> mengajukan izin latihan untuk tanggal <strong>{$formattedDate}</strong> dengan alasan: \"{$this->leave->reason}\".",
            'leave_id'     => $this->leave->id,
            'coach_name'   => $this->coachName,
            'icon'         => 'fa-envelope-open-text',
            'color'        => 'amber',
            'link'         => route('admin.leaves.index'),
        ];
    }

    public function toWhatsapp(object $notifiable): string
    {
        $formattedDate = $this->leave->leave_date->format('d M Y');
        return "Notifikasi Admin:\n\nCoach *{$this->coachName}* mengajukan izin tidak melatih untuk tanggal *{$formattedDate}*.\n\nAlasan: \"{$this->leave->reason}\"\n\nMohon periksa dan proses pengajuan izin ini di dashboard Admin.";
    }
}
