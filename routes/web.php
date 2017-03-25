<?php

// Home
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@show']);

// Authentication
Route::group(['namespace' => 'Auth'], function () {
    // Sessions
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'LoginController@login']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);

    // Registration
    Route::get('register', ['as' => 'register', 'uses' => 'RegisterController@showRegistrationForm']);
    Route::get('signup', 'RegisterController@redirectToRegistrationForm'); // BC for old links
    Route::post('register', ['as' => 'register.post', 'uses' => 'RegisterController@register']);

    // Request password reset
    Route::get('password/reset', ['as' => 'password.forgot', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.forgot.post', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);

    // Password reset
    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'ResetPasswordController@reset']);

    // Email address confirmation
    Route::get('email-address-confirmation', ['as' => 'email.send_confirmation', 'uses' => 'EmailAddressController@sendConfirmation']);
    Route::get('email-address-confirmation/{email_address}/{code}', ['as' => 'email.confirm', 'uses' => 'EmailAddressController@confirm']);

    // Social authentication
    Route::get('login/github', ['as' => 'login.github', 'uses' => 'GithubController@redirectToProvider']);
    Route::get('auth/github', 'GithubController@handleProviderCallback');
});

// Users
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@show']);
Route::get('user/{username}', ['as' => 'profile', 'uses' => 'ProfileController@show']);

// Settings
Route::get('settings', ['as' => 'settings.profile', 'uses' => 'Settings\ProfileController@edit']);
Route::put('settings', ['as' => 'settings.profile.update', 'uses' => 'Settings\ProfileController@update']);
Route::get('settings/password', ['as' => 'settings.password', 'uses' => 'Settings\PasswordController@edit']);
Route::put('settings/password', ['as' => 'settings.password.update', 'uses' => 'Settings\PasswordController@update']);

// Forum
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

// Replies
Route::post('replies', ['as' => 'replies.store', 'uses' => 'ReplyController@store']);
Route::get('replies/{reply}/edit', ['as' => 'replies.edit', 'uses' => 'ReplyController@edit']);
Route::put('replies/{reply}', ['as' => 'replies.update', 'uses' => 'ReplyController@update']);
Route::get('replies/{reply}/delete', ['as' => 'replies.delete', 'uses' => 'ReplyController@delete']);

// Tags
Route::get('tags', ['as' => 'tags', 'uses' => 'TagsController@overview']);
Route::get('tags/{tag}', ['as' => 'tag', 'uses' => 'TagsController@show']);

// Admin
Route::group(['namespace' => 'Admin', 'as' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::get('users/{username}', ['as' => '.users.show', 'uses' => 'UsersController@show']);
    Route::put('users/{username}/ban', ['as' => '.users.ban', 'uses' => 'UsersController@ban']);
    Route::put('users/{username}/unban', ['as' => '.users.unban', 'uses' => 'UsersController@unban']);
    Route::delete('users/{username}', ['as' => '.users.delete', 'uses' => 'UsersController@delete']);
});
