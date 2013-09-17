<?php

Route::get('/', 'Controllers\HomeController@getIndex');

Route::get('login', 'Controllers\AuthController@getLogin');
Route::get('logout', 'Controllers\AuthController@getLogout');
Route::get('oauth', 'Controllers\AuthController@getOauth');

Route::controller('posts', 'Controllers\PostsController');

Route::group(['before' => 'auth', 'prefix' => 'admin'], function() {
    Route::group(['before' => 'has_role:manage_posts'], function() {
        Route::controller('posts', 'Controllers\Admin\PostsController');
    });
});