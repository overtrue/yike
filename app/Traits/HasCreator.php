<?php

namespace App\Traits;

trait HasCreator
{
    public static function bootHasCreator()
    {
        static::creating(function ($object) {
            $object->creator = $object->creator_id ?: auth()->id();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}