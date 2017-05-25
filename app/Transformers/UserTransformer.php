<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transform a user.
     *
     * @param  User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'real_name' => $user->real_name,
            'signature' => $user->signature,
            'is_admin' => $user->is_admin,
            'is_banned' => $user->is_banned,
            'is_verified' => $user->is_verified,
            'is_following' => auth()->check() ? auth()->user()->isFollowing($user->id) : false,
            'is_follow_me' => auth()->check() ? $user->isFollowing(auth()->id()) : false,
            'credit_count' => $user->credit_cache,
            'post_count' => $user->post_cache,
            'comment_count' => $user->comment_cache,
            'follower_count' => $user->follower_cache,
            'unread_count' => $user->unreadNotifications()->count(),
            'github_id' => $user->github_id,
            'linkedin_id' => $user->linkedin_id,
            'twitter_id' => $user->twitter_id,
            'weibo_url' => $user->weibo_url,
            'url' => url($user->username),
            'created_at' => $user->created_at->toIso8601String(),
            'updated_at' => $user->updated_at->toIso8601String(),
        ];
    }
}