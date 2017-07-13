<?php

namespace App;

use Translug;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFollow\Traits\CanBeSubscribed;

class Series extends Model
{
    use Loggable, SoftDeletes, CanBeSubscribed;

    const SERIES_CREATE = 'series.create';
    const SERIES_UPDATE = 'series.update';
    const SERIES_DELETE = 'series.delete';
    const SERIES_SUBSCRIBE = 'series.subscribe';
    const SERIES_UNSUBSCRIBE = 'series.unsubscribe';

    protected $fillable = [
        'user_id', 'image_id', 'title', 'slug', 'description', 'post_cache', 'follower_cache',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($series){
            $series->user_id = auth()->id();
            $series->slug = self::makeUniqueSlug($series);
            static::setActionTypeName(self::SERIES_CREATE);
        });

        static::updating(function($post){
            static::setActionTypeName(self::SERIES_UPDATE);
        });

        static::deleting(function($post){
            static::setActionTypeName(self::SERIES_DELETE);
        });
    }

    public static function makeUniqueSlug($post)
    {
        $title = Translug::translug($post->title);

        while (Series::whereSlug($title)->count()) {
            $title = substr(mt_rand(10, 99), 0, 4)."-{$title}";
        }

        return $title;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'series_post');
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
