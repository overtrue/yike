<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;

class HomeController extends ApiController
{
    public function banners()
    {
        return $this->response->collection(Banner::enabled()->get());
    }
}
