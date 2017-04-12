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

        if ($event->type == $event->comment::COMMENT_UP_VOTE) {
            $event->comment->vote_cache ++;
        } else if ($event->type == $event->comment::COMMENT_DOWN_VOTE){
            $event->comment->vote_cache --;
        }

        $event->comment->save();
    }
}
