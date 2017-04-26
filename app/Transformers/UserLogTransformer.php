<?php

namespace App\Transformers;

use App\UserLog;
use League\Fractal\TransformerAbstract;

class UserLogTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'user',
    ];

    /**
     * List of default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * Transform a UserLog
     *
     * @param  UserLog $action
     *
     * @return array
     */
    public function transform(UserLog $action)
    {
        return [
            'id' => $action->id,
            'action_id' => $action->action_id,
            'action_type' => class_basename($action->action_type),
            'action' => $action->action,
            'changes' => $action->changes,
            'created_at' => $action->created_at->toIso8601String(),
            'updated_at' => $action->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  UserLog $action
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(UserLog $action)
    {
        if($action->user) {
            return $this->item($action->user, new UserTransformer);
        }
    }
}