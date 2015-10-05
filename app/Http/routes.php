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
    // Authentication routes...
    get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
    get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    // Registration routes...
    get('signup', ['as' => 'signup', 'uses' => 'AuthController@getRegister']);
    post('signup', ['as' => 'signup.post', 'uses' => 'AuthController@postRegister']);

    // Password reset link request routes...
    get('forgot-password', ['as' => 'password.forgot', 'uses' => 'PasswordController@getEmail']);
    post('forgot-password', ['as' => 'password.forgot.post', 'uses' => 'PasswordController@postEmail']);

    // Password reset routes...
    get('reset-password/{token}', ['as' => 'password.reset', 'uses' => 'PasswordController@getReset']);
    post('reset-password', ['as' => 'password.reset.post', 'uses' => 'PasswordController@postReset']);

    // Social authentication routes...
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
    get('forum/{slug}', 'ThreadsController@show');
});
