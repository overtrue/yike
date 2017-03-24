<?php

namespace App\Transformers;

use App\UserAction;
use League\Fractal\TransformerAbstract;

class UserActionTransformer extends TransformerAbstract
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
     * Transform a UserAction
     *
     * @param  UserAction $action
     *
     * @return array
     */
    public function transform(UserAction $action)
    {
        return [
            'id' => $action->id,
            'action_id' => $action->action_id,
            'action_type' => $action->action_type,
            'action' => $action->action,
            'changes' => $action->changes,
            'created_at' => $action->created_at->toIso8601String(),
            'updated_at' => $action->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  Post $post
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(UserAction $action)
    {
        if($action->user) {
            return $this->item($action->user, new UserTransformer);
        }
    }
}