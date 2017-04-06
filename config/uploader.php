<?php

/*
 * This file is part of the laravel-uploader.
 *
 * (c) 2016 overtrue <i@overtrue.me>
 */

return [

    'middleware' => ['api', 'jwt.auth'],

    'strategies' => [
        /**
         * default strategy.
         */
        'default' => [
            'mimes' => ['image/jpeg', 'image/png', 'image/bmp', 'image/gif'],
            'disk' => 'public',
            'directory' => '/{Y}/{m}/{d}', // directory,
            'max_file_size' => '2m',
        ],

        // banner extends default
        'banner' => [
            'directory' => 'banners/{Y}/{m}/{d}',
        ],

        // avatar extends default
        'avatar' => [
            'directory' => 'avatars/{Y}/{m}/{d}',
        ],

        // avatar origin extends default
        'avatar_origin' => [
            'directory' => 'avatars/origin/{Y}/{m}/{d}'
        ],

        // post
        'post' => [
            'directory' => 'posts/{Y}/{m}/{d}',
        ],

        // series
        'series' => [
            'directory' => 'series/{Y}/{m}/{d}',
        ],
    ],
];

// @uploader('file', ['strategy' => 'avatar', 'data' => [$product->images]])
