<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $dates = [
        'enabled_at',
        'expired_at',
    ];

    protected $fillable = [
        'creator_id', 'order', 'image_id',
        'title', 'link', 'target', 'description',
        'enabled_at', 'expired_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($banner) {
            $banner->creator_id = auth()->id();
        });
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
