<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function show($id)
    {
        return $this->response->item(User::whereUsername($id)->firstOrFail());
    }
}
