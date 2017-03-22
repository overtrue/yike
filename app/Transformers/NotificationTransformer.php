<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;
use Illuminate\Notifications\DatabaseNotification as Notification;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * Transform a notification
     *
     * @param  Notification $notification
     *
     * @return array
     */
    public function transform(Notification $notification)
    {
        return [
            'id' => $notification->id,
            'type' => snake_case(class_basename($notification->type)),
            'user' => User::find($notification->notifiable_id),
            'data' => $notification->data,
            'read_at' => $notification->read_at,
            'created_at' => $notification->created_at->diffForHumans(),
        ];
    }
}