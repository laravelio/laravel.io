<?php

// We support these old routes to make sure people
// find their way to the new portal website.
Route::group(['domain' => 'wiki.laravel.io'], function() {
    get('{wildcard}', 'HomeController@redirectToMainWebsite');
});
Route::group(['domain' => 'forum.laravel.io'], function() {
    get('{wildcard}', 'HomeController@redirectToMainWebsite');
});
Route::group(['domain' => 'forums.laravel.io'], function() {
    get('{wildcard}', 'HomeController@redirectToMainWebsite');
});

// Home
get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
get('rss', 'HomeController@rss');

// Auth
Route::group(['namespace' => 'Auth'], function () {
    // Authentication
    get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
    get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    // Registration
    get('signup', ['as' => 'signup', 'uses' => 'AuthController@getRegister']);
    post('signup', ['as' => 'signup.post', 'uses' => 'AuthController@postRegister']);

    // Password reset link request
    get('forgot-password', ['as' => 'password.forgot', 'uses' => 'PasswordController@getEmail']);
    post('forgot-password', ['as' => 'password.forgot.post', 'uses' => 'PasswordController@postEmail']);

    // Password reset
    get('reset-password/{token}', ['as' => 'password.reset', 'uses' => 'PasswordController@getReset']);
    post('reset-password', ['as' => 'password.reset.post', 'uses' => 'PasswordController@postReset']);

    // Social authentication
    get('auth/github', 'AuthController@authByGithub');
});

// Users
get('dashboard', ['as' => 'dashboard', 'uses' => 'UsersController@dashboard']);
get('user/{username}', ['as' => 'user', 'uses' => 'UsersController@profile']);

// Paste Bin
get('bin', 'PasteBinController@create');
get('bin/{hash}/raw', 'PasteBinController@raw');
get('bin/{hash}', 'PasteBinController@show');

// Forum
Route::group(['namespace' => 'Forum'], function() {
    get('forum', ['as' => 'forum', 'uses' => 'ThreadsController@overview']);
    get('forum/create-thread', ['as' => 'threads.create', 'uses' => 'ThreadsController@create']);
    post('forum/create-thread', ['as' => 'threads.store', 'uses' => 'ThreadsController@store']);
    get('forum/{thread_slug}', ['as' => 'thread', 'uses' => 'ThreadsController@show']);
    get('forum/{thread_slug}/edit', ['as' => 'threads.edit', 'uses' => 'ThreadsController@edit']);
    put('forum/{thread_slug}', ['as' => 'threads.update', 'uses' => 'ThreadsController@update']);
    get('forum/{thread_slug}/delete', ['as' => 'threads.delete', 'uses' => 'ThreadsController@delete']);
});

// Replies
post('replies', ['as' => 'replies.store', 'uses' => 'ReplyController@store']);
get('replies/{reply}/edit', ['as' => 'replies.edit', 'uses' => 'ReplyController@edit']);
put('replies/{reply}', ['as' => 'replies.update', 'uses' => 'ReplyController@update']);
get('replies/{reply}/delete', ['as' => 'replies.delete', 'uses' => 'ReplyController@delete']);
