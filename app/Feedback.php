<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'user_id', 'image_id', 'ip', 'content',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($feedback) {
            $feedback->user_id = $feedback->user_id ?? auth()->id();
            $feedback->ip = $feedback->ip ?? request()->ip();
        });
    }
}
