<?php

namespace App\Traits;

use App\User;

trait HasCreator
{
    public static function bootHasCreator()
    {
        static::creating(function ($object) {
            $object->creator_id = $object->creator_id ?: auth()->id();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}