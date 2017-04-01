<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\User;
use App\Post;
use App\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class HomeController extends ApiController
{
    public function index()
    {
        $users = User::count();
        $posts = Post::count();
        $tags = Tag::count();
        $series = Series::count();

        return $this->response->json(compact('users', 'posts', 'tags', 'series'));
    }
}
