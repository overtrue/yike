<?php

namespace App\Transformers;

use App\Series;
use League\Fractal\TransformerAbstract;

class SeriesTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'user', 'posts', 'image',
    ];

    /**
     * List of default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user', 'image',
    ];

    /**
     * Transform a series.
     *
     * @param  Series $series
     *
     * @return array
     */
    public function transform(Series $series)
    {
        return [
            'id' => $series->id,
            'image_url' => $series->image_id ? $series->image->url : null,
            'title' => $series->title,
            'slug' => $series->slug,
            'description' => $series->description,
            'post_cache' => $series->post_cache,
            'follower_cache' => $series->follower_cache,
            'follower_cache' => $series->follower_cache,
            'created_at' => $series->created_at->toIso8601String(),
            'updated_at' => $series->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  Series $series
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(Series $series)
    {
        if ($series->user) {
            return $this->item($series->user, new UserTransformer);
        }
    }

    /**
     * Include user.
     *
     * @param  Series $series
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeImage(Series $series)
    {
        if ($series->image) {
            return $this->item($series->image, new ImageTransformer);
        }
    }

    /**
     * Include posts.
     *
     * @param  Series $series
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includePosts(Series $series)
    {
        if ($series->posts) {
            return $this->collection($series->posts, new PostTransformer);
        }
    }
}
