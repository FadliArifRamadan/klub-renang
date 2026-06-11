<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public Payment $payment,
        public string $submitterName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $studentName = $this->payment->student->name ?? 'Murid';
        $amount      = number_format($this->payment->amount, 0, ',', '.');

        return [
            'type'         => 'payment_submitted',
            'title'        => 'Transfer Masuk — Menunggu Verifikasi',
            'body'         => "{$this->submitterName} telah mengunggah bukti transfer untuk murid <strong>{$studentName}</strong> sebesar <strong>Rp {$amount}</strong>.",
            'student_name' => $studentName,
            'amount'       => $this->payment->amount,
            'payment_id'   => $this->payment->id,
            'link'         => route('admin.payments.index'),
            'icon'         => 'fa-file-invoice-dollar',
            'color'        => 'blue',
        ];
    }
}
