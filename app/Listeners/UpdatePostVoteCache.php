<?php

namespace App\Listeners;

use App\Events\VotePost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePostVoteCache
{
    /**
     * Handle the event.
     *
     * @param  ViewPost  $event
     * @return void
     */
    public function handle(VotePost $event)
    {
        $event->post->setActionTypeName($event->type);

        if ($event->type == $event->post::POST_UP_VOTE) {
            $event->post->vote_cache ++;
        } else if ($event->type == $event->post::POST_DOWN_VOTE){
            $event->post->vote_cache --;
        }

        $event->post->save();
    }
}
