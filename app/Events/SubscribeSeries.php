<?php

namespace App\Events;

use App\Series;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SubscribeSeries
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $type;
    public $series;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Series $series, string $type)
    {
        $this->user = auth()->user();
        $this->type = $type;
        $this->series = $series;
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
