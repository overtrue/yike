<?php

namespace App\Transformers;

use App\Image;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    /**
     * Transform a banner.
     *
     * @param  Banner $banner
     *
     * @return array
     */
    public function transform(Image $image)
    {
        return [
            'id' => $image->id,
            'path' => $image->path,
            'title' => $image->title,
            'size' => $image->size,
            'url' => $image->url,
            'creator' => $image->creator,
            'created_at' => $image->created_at,
            'updated_at' => $image->updated_at,
        ];
    }
}