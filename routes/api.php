<?php

Route::group([
    'middleware' => ['api', 'jwt.check'],
], function () {
    Route::get('home/banners', 'HomeController@banners');
    Route::get('home/ranks', 'HomeController@ranks');
    Route::get('/posts/{slug}', 'PostController@show');
    Route::get('/series/{slug}', 'SeriesController@show');
    Route::post('/auth/token/issue', 'AuthController@issueToken');
    Route::post('/auth/token/refresh', 'AuthController@refreshToken');
    Route::resource('/users', 'UserController');
    Route::resource('/posts', 'PostController', ['except' => ['store', 'update']]);
    Route::resource('/series', 'SeriesController', ['except' => ['store', 'update']]);
    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::get('/me', 'MeController@show');
        Route::patch('/me', 'MeController@update');
        Route::get('/me/followers', 'MeController@getFollowers');
        Route::post('/me/followers', 'MeController@postFollowers');
        Route::post('/me/followers/series', 'MeController@postFollowSeries');
        Route::post('/me/voters/comment/{type}', 'MeController@postVoteComment')->where('type', 'up|down');
        Route::get('/me/notifications', 'MeController@getNotifications');
        Route::post('/auth/token/revoke', 'AuthController@revokeToken');
        Route::post('/posts', 'PostController@store');
        Route::patch('/posts/{id}', 'PostController@update');
        Route::post('/posts/{id}/comment', 'PostController@storeComment');

        Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin'], function(){
            Route::resource('users', 'UserController');
            Route::resource('posts', 'PostController');
            Route::resource('comments', 'CommentController');
            Route::resource('tags', 'TagController');
            Route::resource('roles', 'RoleController');
            Route::get('permissions', 'RoleController@permissions');
            Route::patch('roles/{id}/permission', 'RoleController@updatePermission');
            Route::resource('series', 'SeriesController');
            Route::resource('banners', 'BannerController');
            Route::get('statistics', 'HomeController@index');
            Route::get('logs', 'UserLogController@index');
        });
    });
});