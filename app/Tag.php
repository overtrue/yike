<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes, Loggable;

    const TAG_CREATE = 'tag.create';
    const TAG_UPDATE = 'tag.update';
    const TAG_DELETE = 'tag.delete';

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
            static::setActionTypeName(self::TAG_CREATE);
        });

        static::updating(function($post){
            static::setActionTypeName(self::TAG_UPDATE);
        });

        static::deleting(function($post){
            static::setActionTypeName(self::TAG_DELETE);
        });
    }

    public static function makeUniqueSlug($tag)
    {
        $name = translug($tag->name);

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
