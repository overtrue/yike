<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Post;
use App\Image;
use App\Series;
use App\Comment;
use App\Events\VotePost;
use App\Events\VoteComment;
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

    public function postSubscribeSeries(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:series,id',
            ]);

        $this->toggleAction($request->user(), Series::find($request->id), 'subscrib');

        return $this->response->json(['success' => true]);
    }

    public function postLikePost(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:posts,id',
            ]);

        $this->toggleAction($request->user(), Post::find($request->id), 'like');

        return $this->response->json(['success' => true]);
    }

    public function postFavouritePost(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:posts,id',
            ]);

        $this->toggleAction($request->user(), Post::find($request->id), 'favorite');

        return $this->response->json(['success' => true]);
    }

    public function toggleFollow($user, $target)
    {
        $isFollowing = $user->isFollowing($target);

        $isFollowing ? $user->unfollow($target) : $user->follow($target);

        return $isFollowing;
    }

    public function toggleAction($user, $target, $type)
    {
        $isFollowing = $user->{ 'has' . ucfirst($type) . 'd' }($target);

        $isFollowing ? $user->{ 'un' . $type }($target) : $user->{ $type }($target);

        return $isFollowing;
    }

    public function toggleSubscribe($user, $target)
    {
        $isFollowing = $user->hasSubscribed($target);

        $isFollowing ? $user->unsubscribe($target) : $user->subscribe($target);

        return $isFollowing;
    }

    public function postVoteComment(Request $request, $type)
    {
        $this->validate($request, [
                'id' => 'required|exists:comments,id',
            ]);

        $user = $request->user();
        $comment = Comment::find($request->id);

        $voteType = ($type == 'up')
                    ? $this->toggleVote($user, $comment)
                    : $this->toggleDownVote($user, $comment);

        event(new VoteComment($comment, $voteType));

        return $this->response->json(['success' => true]);
    }

    public function toggleVote($user, $target)
    {
        $hasVoted = $user->hasUpVoted($target);

        $hasVoted ? $user->cancelVote($target) : $user->upVote($target);

        return $hasVoted ? $target::COMMENT_CANCEL_UP_VOTE : $target::COMMENT_UP_VOTE;
    }

    public function toggleDownVote($user, $target)
    {
        $hasDownVoted = $user->hasDownVoted($target);

        if ($hasDownVoted) {
            $type = $target::COMMENT_CANCEL_DOWN_VOTE;
            $user->cancelVote($target);
        } else {
            $type = $user->hasUpVoted($target) ? $target::COMMENT_UP_TO_DOWN_VOTE : $target::COMMENT_DOWN_VOTE;
            $user->downVote($target);
        }

        return $type;
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
