<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDiverifikasi extends Notification
{
    use Queueable;

    public function __construct(
        public int $periksaId,
        public string $status,
        public string $message,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->status === 'lunas' ? 'Pembayaran lunas' : 'Pembayaran ditolak',
            'message' => $this->message,
            'type' => 'payment_status',
            'status' => $this->status,
            'periksa_id' => $this->periksaId,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
