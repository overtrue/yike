<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
     * Transform a category.
     *
     * @param  Category $category
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'order' => $category->order,
            'created_at' => $category->created_at->toIso8601String(),
            'updated_at' => $category->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  Category $category
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(Category $category)
    {
        if ($category->user) {
            return $this->item($category->user, new UserTransformer);
        }
    }
}