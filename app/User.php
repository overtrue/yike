<?php

namespace App;

use App\Traits\UserAction;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelFollow\FollowTrait;
use Overtrue\LaravelFollow\FollowerTrait;

class User extends Authenticatable implements JWTSubject
{
    use UserAction, Notifiable, FollowTrait, FollowerTrait;

    const USER_CREATE = 'user.create';
    const USER_UPDATE = 'user.update';
    const USER_DELETE = 'user.delete';
    const USER_CREDIT = 'user.credit';

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
            if (self::$typeName != self::USER_CREDIT) {
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

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
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
