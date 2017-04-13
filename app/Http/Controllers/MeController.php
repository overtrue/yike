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

    public function postVotePost(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:posts,id',
            ]);

        $user = $request->user();
        $post = Post::find($request->id);

        $type = !$this->toggleVote($user, $post) ? $post::POST_UP_VOTE : $post::POST_DOWN_VOTE;

        event(new VotePost($post, $type));

        return $this->response->json(['success' => true]);
    }

    public function postVoteComment(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:comments,id',
            ]);

        $user = $request->user();
        $comment = Comment::find($request->id);

        $type = !$this->toggleVote($user, $comment) ? $comment::COMMENT_UP_VOTE : $comment::COMMENT_DOWN_VOTE;

        event(new VoteComment($comment, $type));

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

    public function toggleVote($user, $target)
    {
        $hasVoted = $user->hasVoted($target);

        $hasVoted ? $user->downVote($target) : $user->upVote($target);

        return $hasVoted;
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
