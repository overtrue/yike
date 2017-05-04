<?php

Route::group([
    'middleware' => ['api', 'jwt.check'],
], function () {
    Route::get('home/banners', 'HomeController@banners');
    Route::get('home/ranks', 'HomeController@ranks');
    Route::get('posts/{slug}', 'PostController@show');
    Route::get('series/{slug}', 'SeriesController@show');
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/token/issue', 'AuthController@issueToken');
    Route::post('auth/token/refresh', 'AuthController@refreshToken');
    Route::resource('users', 'UserController');
    Route::resource('posts', 'PostController', ['except' => ['store', 'update']]);
    Route::resource('series', 'SeriesController', ['except' => ['store', 'update']]);
    Route::post('feedback', 'FeedbackController@store');

    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::get('me', 'MeController@show');
        Route::patch('me', 'MeController@update');
        Route::get('me/followers', 'MeController@getFollowers');
        Route::post('me/followers', 'MeController@postFollowers');
        Route::post('me/followers/series', 'MeController@postSubscribeSeries');
        Route::post('me/subscribers/series', 'MeController@postSubscribeSeries');
        Route::post('me/likers/post', 'MeController@postLikePost');
        Route::post('me/favoriters/post/', 'MeController@postFavouritePost');
        Route::post('me/voters/comment/{type}', 'MeController@postVoteComment')->where('type', 'up|down');
        Route::get('me/notifications', 'MeController@getNotifications');
        Route::post('auth/token/revoke', 'AuthController@revokeToken');
        Route::post('posts', 'PostController@store');
        Route::patch('posts/{id}', 'PostController@update');
        Route::post('posts/{id}/comments', 'PostController@storeComment');
        Route::post('posts/{id}/reports', 'PostController@storeReport');

        Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin'], function(){
            Route::resource('users', 'UserController');
            Route::patch('posts/{id}/recommend', 'PostController@recommend');
            Route::patch('posts/{id}/off', 'PostController@off');
            Route::patch('posts/{id}/ban', 'PostController@ban');
            Route::patch('posts/{id}/lift', 'PostController@lift');
            Route::resource('posts', 'PostController');
            Route::patch('comments/{id}/ban', 'CommentController@ban');
            Route::patch('comments/{id}/lift', 'CommentController@lift');
            Route::resource('comments', 'CommentController');
            Route::resource('tags', 'TagController');
            Route::resource('roles', 'RoleController');
            Route::get('permissions', 'RoleController@permissions');
            Route::patch('roles/{id}/permission', 'RoleController@updatePermission');
            Route::resource('series', 'SeriesController');
            Route::resource('banners', 'BannerController');
            Route::get('statistics', 'HomeController@index');
            Route::get('logs', 'UserLogController@index');
            Route::get('reports', 'ReportController@index');
            Route::resource('feedback', 'FeedbackController');
        });
    });
});