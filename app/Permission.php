<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles()
    {
        return $this->blongsToMany(Role::class);
    }
}
