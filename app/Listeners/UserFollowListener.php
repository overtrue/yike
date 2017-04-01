<?php

namespace App\Listeners;

use App\Events\UserFollow;
use App\Notifications\UserFollow as UserFollowNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserFollowListener
{
    /**
     * Handle the event.
     *
     * @param  UserFollow  $event
     * @return void
     */
    public function handle(UserFollow $event)
    {
        $event->targetUser->notify(new UserFollowNotification($event->user));
    }
}
