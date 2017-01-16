<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class MeController extends ApiController
{
    public function show()
    {
        return $this->response->item(Auth::user());
    }
}
