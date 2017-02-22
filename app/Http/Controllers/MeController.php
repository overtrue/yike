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

    public function postFollowers(Request $request)
    {
        $this->validate($request, [
                'user_id' => 'required|exists:users,id',
            ]);

        $user = $request->user();
        $targetUserId = $request->user_id;

        if ($user->isFollowing($targetUserId)) {
            $user->unfollow($targetUserId);
        } else {
            $user->follow($targetUserId);
        }

        return $this->response->json(['success' => true]);
    }

    public function getFollowers()
    {
        return $this->response->collection(auth()->user()->followers());
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('name', 'avatar', 'real_name', 'signature'));

        return $this->response->item($user);
    }
}
