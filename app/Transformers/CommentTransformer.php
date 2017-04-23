<?php

namespace App\Transformers;

use App\Post;
use App\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'user', 'post',
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
     * @param  Comment $comment
     *
     * @return array
     */
    public function transform(Comment $comment)
    {
        $commentableType = explode('\\', $comment->commentable_type);

        return [
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'type' => end($commentableType),
            'content' => $comment->content,
            'raw_content' => $comment->content_original,
            'vote_count'  => $comment->vote_cache,
            'is_down_voting' => auth()->check() ? auth()->user()->hasDownVoted($comment) : false,
            'is_voting'  => auth()->check() ? auth()->user()->hasUpVoted($comment) : false,
            'created_at' => $comment->created_at->toIso8601String(),
            'updated_at' => $comment->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  Comment $comment
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(Comment $comment)
    {
        if ($comment->user) {
            return $this->item($comment->user, new UserTransformer);
        }
    }

    /**
     * Include post.
     *
     * @param  Comment $comment
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePost(Comment $comment)
    {
        if ($comment->commentable_type == Post::class && $comment->commentable) {
            return $this->item($comment->commentable, new PostTransformer);
        }
    }
}