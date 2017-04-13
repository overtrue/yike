<?php

namespace App\Http\Controllers;

use App\User;
use App\Banner;
use Illuminate\Http\Request;

class HomeController extends ApiController
{
    public function banners()
    {
        return $this->response->collection(Banner::enabled()->take(6)->get());
    }

    public function ranks()
    {
        $users = User::orderBy('credit_cache', 'desc')->take(10)->get();

        return $this->response->collection($users);
    }
}
