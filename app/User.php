<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelFollow\FollowTrait;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, FollowTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar', 'real_name',
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

    public function series()
    {
        return $this->hasMany(Series::class);
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarAttribute($avatar)
    {
        return asset($avatar ?? '/img/default-avatar.png');
    }
}
