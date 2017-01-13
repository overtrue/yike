<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelFollow\FollowTrait;

class User extends Authenticatable
{
    use Notifiable, FollowTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'real_name',
        'signature', 'is_admin', 'is_banned', 'is_verified',
        'post_cache', 'comment_cache', 'follower_cache',
        'github_id', 'linkedin_id', 'twitter_id', 'weibo_url',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function profile()
    {
        return $this->hasMany(Profile::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}
