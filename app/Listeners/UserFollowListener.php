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
        $event->targetUser->setActionTypeName($event->type);

        if ($event->type == $event->user::USER_FOLLOW) {
            $event->targetUser->follower_cache ++;

            $event->targetUser->notify(new UserFollowNotification($event->user));
        } else if ($event->type == $event->user::USER_UNFOLLOW){
            $event->targetUser->follower_cache --;
        }

        $event->targetUser->save();
    }
}
