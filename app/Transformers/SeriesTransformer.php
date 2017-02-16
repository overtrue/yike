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
        'creator',
    ];

    /**
     * List of default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'creator',
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
            'title' => $series->title,
            'post_cache' => $series->post_cache,
            'created_at' => $series->created_at->toIso8601String(),
            'updated_at' => $series->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include creator.
     *
     * @param  Series $series
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeCreator(Series $series)
    {
        if ($series->creator) {
            return $this->item($series->creator, new UserTransformer);
        }
    }
}
