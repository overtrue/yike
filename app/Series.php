<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = [
        'user_id', 'title', 'post_cache',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($series){
            $series->user_id = auth()->id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, 'series_post');
    }
}
