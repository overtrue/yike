<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'creator_id', 'path', 'title', 'size',
    ];

    public function url()
    {
        return asset($this->path);
    }
}
