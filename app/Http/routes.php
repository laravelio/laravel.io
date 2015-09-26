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
    get('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    get('auth/github', 'AuthController@authByGithub');
    get('signup', ['as' => 'signup', 'uses' => 'AuthController@signup']);
    get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
});

// Users
get('user/{username}', ['as' => 'user', 'uses' => 'UsersController@profile']);

// Paste Bin
get('bin', 'PasteBinController@create');
get('bin/{hash}/raw', 'PasteBinController@raw');
get('bin/{hash}', 'PasteBinController@show');

// Forum
Route::group(['namespace' => 'Forum'], function() {
    get('forum/{slug}', 'ThreadsController@show');
});
