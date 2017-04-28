<?php

namespace App;

use Facades\Parsedown;
use App\Traits\Loggable;
use Jcc\LaravelVote\CanBeVoted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes, Loggable, CanBeVoted;

    protected $vote = User::class;

    const COMMENT_CREATE = 'comment.create';
    const COMMENT_UPDATE = 'comment.update';
    const COMMENT_DELETE = 'comment.delete';
    const COMMENT_UP_VOTE = 'comment.up_vote';
    const COMMENT_DOWN_VOTE = 'comment.down_vote';
    const COMMENT_CANCEL_UP_VOTE = 'comment.cancel_up_vote';
    const COMMENT_CANCEL_DOWN_VOTE = 'comment.cancel_down_vote';
    const COMMENT_UP_TO_DOWN_VOTE = 'comment.up_to_down_vote';

    const TYPE_MARKDOWN = 'markdown';
    const TYPE_HTML = 'html';

    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type',
        'type', 'content', 'content_original', 'vote_cache',
        'banned_reason', 'banned_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($comment){
            $comment->user_id = auth()->id();
            $comment->content_original = $comment->content_original ?: $comment->content;
            static::setActionTypeName(self::COMMENT_CREATE);
        });

        static::updating(function($post){
            static::setActionTypeName(self::COMMENT_UPDATE);
        });

        static::saving(function ($comment) {
            if(auth()->check() && $comment->isDirty('content') && $comment->type == self::TYPE_MARKDOWN) {
                $comment->content_original = $comment->content;
                $comment->content = preg_replace('/<code>/', '<code class="language-php">', Parsedown::text($comment->content));
            }
        });

        static::deleting(function ($comment) {
            static::setActionTypeName(self::COMMENT_DELETE);
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
