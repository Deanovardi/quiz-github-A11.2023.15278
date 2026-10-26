<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDiunggah extends Notification
{
    use Queueable;

    public function __construct(
        public int $periksaId,
        public string $namaPasien,
        public string $poli,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Bukti pembayaran baru',
            'message' => 'Pasien ' . $this->namaPasien . ' mengunggah bukti pembayaran untuk poli ' . $this->poli . '.',
            'type' => 'payment_upload',
            'periksa_id' => $this->periksaId,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
