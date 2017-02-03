<?php

namespace App;

use Facades\Parsedown;
use Translug;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const TYPE_MARKDOWN = 'markdown';
    const TYPE_HTML = 'html';

    protected $fillable = [
        'user_id', 'is_spammed', 'is_draft', 'title', 'slug', 'type',
        'content', 'content_original', 'published_at', 'image_id',
    ];

    protected $casts = [
        'is_spammed' => 'boolean',
        'is_draft' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($post){
            $post->user_id = auth()->id();
            $post->content_original = $post->content_original ?: $post->content;
            $post->slug = self::makeUniqueSlug($post);
        });

        static::saving(function($post){
            $post->is_draft = (bool) $post->is_draft;
            $post->is_spammed = (bool) $post->is_spammed;

            if ($post->isDirty('content') && $post->type == self::TYPE_MARKDOWN) {
                $post->content_original = $post->content;
                $post->content = preg_replace('/<code>/', '<code class="language-php">', Parsedown::text($post->content));
            }
        });
    }

    public static function makeUniqueSlug($post)
    {
        $title = Translug::translug($post->title);

        while (Post::whereSlug($title)->count()) {
            $title = "{$title}-".substr(mt_rand(1000, 9999), 0, 4);
        }

        return $title;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function scopeNoDraft($query)
    {
        return $query->where('is_draft', 0);
    }
}
