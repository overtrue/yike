<?php

Route::group([
    'middleware' => ['api'],
], function () {
    Route::get('home/banners', 'HomeController@banners');
    Route::get('/posts/{slug}', 'PostController@show');
    Route::post('/auth/token/issue', 'AuthController@issueToken');
    Route::post('/auth/token/refresh', 'AuthController@refreshToken');
    Route::resource('/users', 'UserController');
    Route::resource('/posts', 'PostController', ['except' => ['store', 'update']]);
    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::get('/me', 'MeController@show');
        Route::post('/auth/token/revoke', 'AuthController@revokeToken');
        Route::post('/posts', 'PostController@store');
        Route::patch('/posts/{id}', 'PostController@update');

        Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin'], function(){
            Route::resource('users', 'UserController');
            Route::resource('posts', 'PostController');
            Route::resource('tags', 'TagController');
            Route::resource('roles', 'RoleController');
            Route::get('permissions', 'RoleController@permissions');
            Route::patch('roles/{id}/permission', 'RoleController@updatePermission');
            Route::resource('series', 'SeriesController');
            Route::resource('banners', 'BannerController');
        });
    });
});