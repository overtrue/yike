<?php

namespace App\Listeners;

use App\Events\VoteComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCommentVoteCache
{
    /**
     * Handle the event.
     *
     * @param  ViewPost  $event
     * @return void
     */
    public function handle(VoteComment $event)
    {
        $event->comment->setActionTypeName($event->type);

        $types = [
            $event->comment::COMMENT_CANCEL_UP_VOTE,
            $event->comment::COMMENT_UP_TO_DOWN_VOTE,
        ];

        if ($event->type == $event->comment::COMMENT_UP_VOTE) {
            $event->comment->vote_cache ++;
        } else if (in_array($event->type, $types)){
            $event->comment->vote_cache --;
        }

        $event->comment->save();
    }
}
