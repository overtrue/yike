<?php

namespace App\Http\Controllers\Admin;

use App\UserAction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserActionController extends ApiController
{
    public function index()
    {
        return $this->response->collection(UserAction::paginate(10));
    }
}
