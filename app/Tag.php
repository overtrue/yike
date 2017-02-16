<?php

namespace App;

use Translug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'creator_id', 'name', 'slug',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($tag) {
            $tag->creator_id = auth()->id();
            $tag->slug = self::makeUniqueSlug($tag);
        });
    }

    public static function makeUniqueSlug($tag)
    {
        $name = Translug::translug($tag->name);

        while (Tag::whereSlug($name)->count()) {
            $name = "{$name}-".substr(mt_rand(1000, 9999), 0, 4);
        }

        return $name;
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
