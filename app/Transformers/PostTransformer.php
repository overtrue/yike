<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'user',
    ];

    /**
     * List of default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * Transform a post.
     *
     * @param  Post $post
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'title' => $post->title,
            'slug' => $post->slug,
            'cover' => $post->image_id ? $post->image->url : null,
            'content' => $post->content,
            'signature' => $post->signature,
            'is_spammed' => $post->is_spammed,
            'comment_count' => $post->comment_cache,
            'vote_count' => $post->vote_cache,
            'view_count' => $post->view_cache,
            'url' => '/'.$post->user->username.'/'.$post->slug,
            'created_at' => $post->created_at->toIso8601String(),
            'updated_at' => $post->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  Post $post
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(Post $post)
    {
        if ($post->user) {
            return $this->item($post->user, new UserTransformer);
        }
    }
}