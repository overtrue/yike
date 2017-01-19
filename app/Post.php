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
        'user_id', 'is_spammed', 'title', 'slug',
        'content', 'content_original', 'published_at', 'image_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($post){
            $post->user_id = auth()->id();
            $post->content_original = $post->content_original ?: $post->content;
            $post->slug = Translug::translug($post->title).'-'.uniqid();
        });

        static::saving(function($post){
            if ($post->type == self::TYPE_MARKDOWN) {
                $post->content = Parsedown::text($post->content);
            }
        });
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
}
