<?php

namespace App\Transformers;

use App\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    /**
     * Transform a permission
     *
     * @param  Permission $permission
     *
     * @return array
     */
    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
            'type' => explode('.', $permission->name)[0],
            'display_name' => $permission->display_name,
            'description' => $permission->description,
            'created_at' => $permission->created_at->toIso8601String(),
            'updated_at' => $permission->updated_at->toIso8601String(),
        ];
    }
}
