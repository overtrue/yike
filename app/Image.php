<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function url()
    {
        return asset($this->path);
    }
}
