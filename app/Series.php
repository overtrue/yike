<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = [
        'creator_id', 'title', 'post_cache',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($series){
            $series->creator_id = auth()->id();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, 'series_post');
    }
}
