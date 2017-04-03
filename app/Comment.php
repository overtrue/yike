<?php

namespace App;

use Facades\Parsedown;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const TYPE_MARKDOWN = 'markdown';
    const TYPE_HTML = 'html';

    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type',
        'type', 'content', 'content_original', 'vote_cache',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($comment){
            $comment->user_id = auth()->id();
            $comment->content_original = $comment->content_original ?: $comment->content;
        });

        static::saving(function ($comment) {
            if(auth()->check() && $comment->isDirty('content') && $comment->type == self::TYPE_MARKDOWN) {
                $comment->content_original = $comment->content;
                $comment->content = preg_replace('/<code>/', '<code class="language-php">', Parsedown::text($comment->content));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
