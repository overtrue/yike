<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreditChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $credit;

    /**
     * Create a new event instance.
     *
     * @param int $credit
     *
     * @return void
     */
    public function __construct(int $credit)
    {
        $this->user = auth()->user();
        $this->credit = $credit;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
