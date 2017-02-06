<?php

namespace App\Transformers;

use App\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    /**
     * List of resource possible to include.
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
     * Transform a tag
     *
     * @param  Tag $tag
     *
     * @return array
     */
    public function transform(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
            'created_at' => $tag->created_at->toIso8601String(),
            'updated_at' => $tag->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  Tag $tag
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(Tag $tag)
    {
        if ($tag->user) {
            return $this->item($tag->user, new UserTransformer);
        }
    }
}