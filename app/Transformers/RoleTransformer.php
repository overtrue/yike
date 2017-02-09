<?php

namespace App\Transformers;

use App\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform a role
     *
     * @param  Role $role
     *
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'display_name' => $role->display_name,
            'description' => $role->description,
            'permissions' => $role->permissions->pluck('id')->toArray(),
            'created_at' => $role->created_at->toIso8601String(),
            'updated_at' => $role->updated_at->toIso8601String(),
        ];
    }
}
