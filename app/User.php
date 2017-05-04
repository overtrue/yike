<?php

namespace App;

use App\Traits\Loggable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jcc\LaravelVote\Vote;
use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Overtrue\LaravelFollow\Traits\CanLike;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;

class User extends Authenticatable implements JWTSubject
{
    use Loggable, Notifiable, CanSubscribe, CanLike, CanFavorite, CanFollow, CanBeFollowed, Vote;

    const USER_CREATE = 'user.create';
    const USER_UPDATE = 'user.update';
    const USER_DELETE = 'user.delete';
    const USER_CREDIT = 'user.credit';
    const USER_FOLLOW = 'user.follow';
    const USER_UNFOLLOW = 'user.unfollow';

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

    public static function boot()
    {
        parent::boot();

        static::creating(function($post){
            static::setActionTypeName(self::USER_CREATE);
        });

        static::updating(function($post){
            $types = [
                self::USER_CREDIT,
                self::USER_FOLLOW,
                self::USER_UNFOLLOW
            ];

            if (!in_array(self::$typeName, $types)) {
                static::setActionTypeName(self::USER_UPDATE);
            }
        });

        static::deleting(function($post){
            static::setActionTypeName(self::USER_DELETE);
        });
    }

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

    public function series()
    {
        return $this->hasMany(Series::class);
    }

    public function actions()
    {
        return $this->morphMany(UserAction::class, 'action');
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
