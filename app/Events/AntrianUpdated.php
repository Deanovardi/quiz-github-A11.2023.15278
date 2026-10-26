<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $jadwal_id;
    public $current_antrian;

    public function __construct($jadwal_id, $current_antrian)
    {
        $this->jadwal_id = $jadwal_id;
        $this->current_antrian = $current_antrian;
    }

    public function broadcastOn()
    {
        return new Channel('antrian-channel');
    }

    public function broadcastAs()
    {
        return 'AntrianUpdated';
    }
}