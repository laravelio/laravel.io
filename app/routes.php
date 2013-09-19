<?php

Route::get('/', 'Controllers\HomeController@getIndex');

Route::get('login', 'Controllers\AuthController@getLogin');
Route::get('logout', 'Controllers\AuthController@getLogout');
Route::get('oauth', 'Controllers\AuthController@getOauth');

Route::controller('articles', 'Controllers\PostsController');
Route::controller('pastes', 'Controllers\PastesController');

// forum
Route::get('forum', 'Controllers\ForumController@getIndex');
Route::get('forum/{forumCategory}', 'Controllers\ForumController@getCategory');
Route::get('forum/{forumCategory}/create-thread', 'Controllers\ForumController@getCreateThread');
Route::post('forum/{forumCategory}/create-thread', 'Controllers\ForumController@postCreateThread');
Route::get('forum/{forumCategory}/{slug}', ['before' => 'handle_slug', 'uses' => 'Controllers\ForumController@getThread']);

// admin
Route::group(['before' => 'auth', 'prefix' => 'admin'], function() {

    Route::group(['before' => 'has_role:admin_posts'], function() {
        Route::controller('posts', 'Controllers\Admin\PostsController');
    });

    Route::group(['before' => 'has_role:admin_users'], function() {
        Route::controller('users', 'Controllers\Admin\UsersController');
    });
});