<?php

namespace App\Listeners;

use App\Events\UserCreditChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddUserCreditListener
{
    /**
     * Handle the event.
     *
     * @param  UserCreditChanged  $event
     * @return void
     */
    public function handle(UserCreditChanged $event)
    {
        $event->user->setActionTypeName($event->user::USER_CREDIT);

        $event->user->credit_cache += $event->credit;

        $event->user->save();
    }
}
