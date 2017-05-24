<?php

namespace App\Listeners;

use App\Events\FavoritePost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\FavoritePost as FavoritePostNotification;

class UpdatePostFavoriteCache
{
    /**
     * Handle the event.
     *
     * @param  FavoritePost  $event
     * @return void
     */
    public function handle(FavoritePost $event)
    {
        $event->post->setActionTypeName($event->type);

        if ($event->type == $event->post::POST_FAVORITE) {
            $event->post->favorite_cache ++;

            $event->post->user->notify(new FavoritePostNotification($event->post, $event->user));
        } else if ($event->type == $event->post::POST_UNFAVORITE){
            $event->post->favorite_cache --;
        }

        $event->post->save();
    }
}
