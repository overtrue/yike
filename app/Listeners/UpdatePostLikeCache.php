<?php

namespace App\Listeners;

use App\Events\LikePost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePostLikeCache
{
    /**
     * Handle the event.
     *
     * @param  LikePost  $event
     * @return void
     */
    public function handle(LikePost $event)
    {
        $event->post->setActionTypeName($event->type);

        if ($event->type == $event->post::POST_LIKE) {
            $event->post->like_cache ++;
        } else if ($event->type == $event->post::POST_UNLIKE){
            $event->post->like_cache --;
        }

        $event->post->save();
    }
}
