<?php

namespace App\Transformers;

use App\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'creator', 'image',
    ];

    /**
     * List of default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'image',
    ];

    /**
     * Transform a banner.
     *
     * @param  Banner $banner
     *
     * @return array
     */
    public function transform(Banner $banner)
    {
        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'link' => $banner->link,
            'target' => $banner->target,
            'description' => $banner->description,
            'enabled_at' => $banner->enabled_at->toIso8601String(),
            'expired_at' => $banner->expired_at->toIso8601String(),
            'created_at' => $banner->created_at->toIso8601String(),
            'updated_at' => $banner->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include creator.
     *
     * @param  Banner $banner
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeCreator(Banner $banner)
    {
        if ($banner->creator) {
            return $this->item($banner->creator, new UserTransformer);
        }
    }

    /**
     * Include image.
     *
     * @param  Banner $banner
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeImage(Banner $banner)
    {
        if ($banner->image) {
            return $this->item($banner->image, new ImageTransformer);
        }
    }
}
