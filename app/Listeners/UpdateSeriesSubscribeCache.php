<?php

namespace App\Listeners;

use App\Events\SubscribeSeries;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSeriesSubscribeCache
{
    /**
     * Handle the event.
     *
     * @param  SubscribeSeries  $event
     * @return void
     */
    public function handle(SubscribeSeries $event)
    {
        $event->series->setActionTypeName($event->type);

        if ($event->type == $event->series::SERIES_SUBSCRIBE) {
            $event->series->subscriber_cache ++;
        } else if ($event->type == $event->series::SERIES_UNSUBSCRIBE){
            $event->series->subscriber_cache --;
        }

        $event->series->save();
    }
}
