<?php

namespace App\Listeners;

use App\Events\UserCredit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddUserCreditListener
{
    /**
     * Handle the event.
     *
     * @param  UserCredit  $event
     * @return void
     */
    public function handle(UserCredit $event)
    {
        $event->user->setActionTypeName($event->user::USER_CREDIT);

        $event->user->credit_cache += $event->credit;

        $event->user->save();
    }
}
