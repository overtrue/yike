<?php

namespace App\Events;

use App\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VoteComment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $type;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, string $type)
    {
        $this->comment = $comment;
        $this->type = $type;
        $this->user = auth()->user();
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
