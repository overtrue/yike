<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
