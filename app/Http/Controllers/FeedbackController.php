<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends ApiController
{
    public function store(Request $request)
    {
        Feedback::create($request->only('content'));

        return $this->response->withNoContent();
    }
}
