<?php

namespace App;

use Carbon\Carbon;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use Loggable, SoftDeletes;

    const BANNER_CREATE = 'banner.create';
    const BANNER_UPDATE = 'banner.update';
    const BANNER_DELETE = 'banner.delete';

    protected $dates = [
        'enabled_at',
        'expired_at',
    ];

    protected $fillable = [
        'creator_id', 'order', 'image_id',
        'title', 'link', 'target', 'description',
        'enabled_at', 'expired_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($banner) {
            $banner->creator_id = auth()->id();
            static::setActionTypeName(self::BANNER_CREATE);
        });

        static::updating(function($post){
            static::setActionTypeName(self::BANNER_UPDATE);
        });

        static::deleting(function($post){
            static::setActionTypeName(self::BANNER_DELETE);
        });
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeEnabled($query)
    {
        $now = Carbon::now();

        return $query->where('enabled_at', '<=', $now)->where('expired_at', '>=', $now);
    }
}
