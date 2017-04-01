<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Image;
use App\Series;
use App\Events\UserFollow;
use Illuminate\Http\Request;
use App\Http\Requests\MeRequest;
use App\Transformers\NotificationTransformer;

class MeController extends ApiController
{
    public function show()
    {
        return $this->response->item(Auth::user());
    }

    public function postFollowers(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:users,id',
            ]);

        $user = $request->user();
        $target = User::find($request->id);

        if (!$this->toggleFollow($user, $target)) {
            event(new UserFollow($user, $target));
        }

        return $this->response->json(['success' => true]);
    }

    public function postFollowSeries(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:series,id',
            ]);

        $this->toggleFollow($request->user(), Series::find($request->id));

        return $this->response->json(['success' => true]);
    }

    public function toggleFollow($user, $target)
    {
        $isFollowing = $user->isFollowing($target);

        $isFollowing ? $user->unfollow($target) : $user->follow($target);

        return $isFollowing;
    }

    public function getFollowers()
    {
        return $this->response->collection(auth()->user()->followers());
    }

    public function update(MeRequest $request)
    {
        $user = auth()->user();

        $user->update($request->onlyThem(['name', 'signature']));

        return $this->response->item($user);
    }

    public function getNotifications()
    {
        return $this->response->collection(auth()->user()->notifications, new NotificationTransformer);
    }
}
