<?php

// We support these old routes to make sure people
// find their way to the new portal website.
collect(['wiki', 'forum', 'forums'])->each(function ($subdomain) {
    Route::group(['domain' => $subdomain.'.laravel.io'], function() {
        Route::get('{wildcard}', 'HomeController@redirectToMainWebsite');
    });
});

// Home
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
Route::get('rss', 'HomeController@rss');

// Authentication
Route::group(['namespace' => 'Auth'], function () {
    // Sessions
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    // Registration
    Route::get('signup', ['as' => 'signup', 'uses' => 'AuthController@getRegister']);
    Route::post('signup', ['as' => 'signup.post', 'uses' => 'AuthController@postRegister']);

    // Password reset link request
    Route::get('forgot-password', ['as' => 'password.forgot', 'uses' => 'PasswordController@getEmail']);
    Route::post('forgot-password', ['as' => 'password.forgot.post', 'uses' => 'PasswordController@postEmail']);

    // Password reset
    Route::get('reset-password/{token}', ['as' => 'password.reset', 'uses' => 'PasswordController@getReset']);
    Route::post('reset-password', ['as' => 'password.reset.post', 'uses' => 'PasswordController@postReset']);

    // Social authentication
    Route::get('auth/github', 'AuthController@authByGithub');
});

// Users
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'UsersController@dashboard']);
Route::get('user/{username}', ['as' => 'profile', 'uses' => 'UsersController@profile']);

// Settings
Route::get('settings', ['as' => 'settings.profile', 'uses' => 'SettingsController@profile']);
Route::put('settings', ['as' => 'settings.profile.update', 'uses' => 'SettingsController@updateProfile']);
Route::get('settings/password', ['as' => 'settings.password', 'uses' => 'SettingsController@password']);
Route::put('settings/password', ['as' => 'settings.password.update', 'uses' => 'SettingsController@updatePassword']);

// Paste Bin
Route::get('bin', 'PasteBinController@create');
Route::get('bin/{hash}/raw', 'PasteBinController@raw');
Route::get('bin/{hash}', 'PasteBinController@show');

// Forum
Route::group(['namespace' => 'Forum'], function() {
    Route::get('forum', ['as' => 'forum', 'uses' => 'ThreadsController@overview']);
    Route::get('forum/create-thread', ['as' => 'threads.create', 'uses' => 'ThreadsController@create']);
    Route::post('forum/create-thread', ['as' => 'threads.store', 'uses' => 'ThreadsController@store']);
    Route::get('forum/{thread}', ['as' => 'thread', 'uses' => 'ThreadsController@show']);
    Route::get('forum/{thread}/edit', ['as' => 'threads.edit', 'uses' => 'ThreadsController@edit']);
    Route::put('forum/{thread}', ['as' => 'threads.update', 'uses' => 'ThreadsController@update']);
    Route::get('forum/{thread}/delete', ['as' => 'threads.delete', 'uses' => 'ThreadsController@delete']);
    Route::get('forum/{thread}/mark-solution/{reply}', ['as' => 'threads.solution.mark', 'uses' => 'ThreadsController@markSolution']);
    Route::get('forum/{thread}/unmark-solution', ['as' => 'threads.solution.unmark', 'uses' => 'ThreadsController@unmarkSolution']);

    // Topics
    Route::get('forum/topics/{topic}', ['as' => 'forum.topic', 'uses' => 'TopicController@show']);
});

// Replies
Route::post('replies', ['as' => 'replies.store', 'uses' => 'ReplyController@store']);
Route::get('replies/{reply}/edit', ['as' => 'replies.edit', 'uses' => 'ReplyController@edit']);
Route::put('replies/{reply}', ['as' => 'replies.update', 'uses' => 'ReplyController@update']);
Route::get('replies/{reply}/delete', ['as' => 'replies.delete', 'uses' => 'ReplyController@delete']);

// Tags
Route::get('tags', ['as' => 'tags', 'uses' => 'TagsController@overview']);
Route::get('tags/{tag}', ['as' => 'tag', 'uses' => 'TagsController@show']);
