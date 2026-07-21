<?php

namespace App\Notifications;

use App\Models\CoachLeave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\WhatsappChannel;

class CoachLeaveRejected extends Notification
{
    use Queueable;

    public function __construct(
        public CoachLeave $leave,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WhatsappChannel::class];
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

    public function toWhatsapp(object $notifiable): string
    {
        $formattedDate = $this->leave->leave_date->format('d M Y');
        return "Halo Coach {$notifiable->name},\n\nPengajuan izin latihan Anda untuk tanggal *{$formattedDate}* telah *DITOLAK* oleh Admin.\n\nAlasan penolakan: \"{$this->leave->rejection_reason}\"\n\nMohon periksa kembali jadwal Anda atau ajukan ulang jika ada kekeliruan.";
    }
}
