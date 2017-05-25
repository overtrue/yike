<?php

namespace App\Listeners;

use App\Events\LikePost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\LikePost as LikePostNotification;

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

            $event->post->user->notify(new LikePostNotification($event->post, $event->user));
        } else if ($event->type == $event->post::POST_UNLIKE){
            $event->post->like_cache --;
        }

        $event->post->save();
    }
}
