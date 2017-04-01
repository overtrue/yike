<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserFollow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $targetUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, User $targetUser)
    {
        $this->user = $user;
        $this->targetUser = $targetUser;
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
