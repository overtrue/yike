<?php

Route::group([
    'middleware' => ['api'],
], function () {
    Route::post('/auth/token/issue', 'AuthController@issueToken');
    Route::post('/auth/token/refresh', 'AuthController@refreshToken');
    Route::resource('/users', 'UserController');
    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::get('/me', 'MeController@show');
        Route::post('/auth/token/revoke', 'AuthController@revokeToken');
    });
});