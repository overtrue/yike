<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
        'user_id',
        'action_id',
        'action_type',
        'action',
        'changes',
    ];

    protected $casts = [
        'changes' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function action()
    {
        return $this->morphTo();
    }
}
