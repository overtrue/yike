<?php

namespace App\Transformers;

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
            'vote_count' => $comment->vote_cache,
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
}