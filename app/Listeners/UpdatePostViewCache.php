<?php

namespace App\Listeners;

use App\Events\ViewPost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePostViewCache
{
    /**
     * Handle the event.
     *
     * @param  ViewPost  $event
     * @return void
     */
    public function handle(ViewPost $event)
    {
        $event->post->setActionTypeName($event->post::POST_VIEW);

        $event->post->view_cache = $event->post->view_cache + 1;

        $event->post->save();
    }
}
