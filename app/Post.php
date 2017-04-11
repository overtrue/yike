<?php

namespace App;

use Translug;
use Facades\Parsedown;
use App\Traits\UserAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, UserAction;

    const POST_UP_VOTE = 'post.up_vote';
    const POST_DOWN_VOTE = 'post.down_vote';
    const POST_VIEW = 'post.view';
    const POST_PUBLISH = 'post.publish';
    const POST_UPDATE = 'post.update';
    const POST_DELETE = 'post.delete';

    const TYPE_MARKDOWN = 'markdown';
    const TYPE_HTML = 'html';

    protected $fillable = [
        'user_id', 'is_spammed', 'is_draft', 'title', 'slug', 'type',
        'content', 'content_original', 'published_at', 'image_id', 'last_edit_user_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
            static::setActionTypeName(self::POST_PUBLISH);
        });

        static::updating(function($post){
            if (!in_array(self::$typeName, [self::POST_VIEW, self::POST_UP_VOTE, self::POST_DOWN_VOTE])) {
                static::setActionTypeName(self::POST_UPDATE);
            }
        });

        static::deleting(function($post){
            static::setActionTypeName(self::POST_DELETE);
        });

        static::saving(function($post){
            if(auth()->check()) {
                $post->last_edit_user_id = auth()->id();
                $post->is_draft = (bool) $post->is_draft;
                $post->is_spammed = (bool) $post->is_spammed;

                if ($post->isDirty('content') && $post->type == self::TYPE_MARKDOWN) {
                    $post->content_original = $post->content;
                    $post->content = preg_replace('/<code>/', '<code class="language-php">', Parsedown::text($post->content));
                }
            }
        });
    }

    public static function makeUniqueSlug($post)
    {
        $title = Translug::translug($post->title);

        while (Post::whereSlug($title)->count()) {
            $title = substr(mt_rand(10, 99), 0, 4)."-{$title}";
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

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function series()
    {
        return $this->hasManyThrough(Series::class, 'series_post');
    }

    public function scopeNoDraft($query)
    {
        return $query->where('is_draft', 0);
    }

    public function scopeHot($query)
    {
        return $query->orderBy('view_cache', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecommends($query)
    {
        return $query->orderBy('vote_cache', 'desc');
    }

    public function scopeFeatured($query)
    {
        //TODO: 未实现
        return $query;
    }
}
