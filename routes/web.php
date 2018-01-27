<?php

// Home
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@show']);
Route::get('rules', ['as' => 'rules', 'uses' => 'HomeController@rules']);
Route::get('bin/{paste?}', 'HomeController@pastebin');

// Authentication
Route::group(['namespace' => 'Auth'], function () {
    // Sessions
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'LoginController@login']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);

    // Registration
    Route::get('register', ['as' => 'register', 'uses' => 'RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'RegisterController@register']);

    // Password reset
    Route::get('password/reset', ['as' => 'password.forgot', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.forgot.post', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'ResetPasswordController@reset']);

    // Email address confirmation
    Route::get('email-confirmation', ['as' => 'email.send_confirmation', 'uses' => 'EmailConfirmationController@send']);
    Route::get('email-confirmation/{email_address}/{code}', ['as' => 'email.confirm', 'uses' => 'EmailConfirmationController@confirm']);

    // Social authentication
    Route::get('login/github', ['as' => 'login.github', 'uses' => 'GithubController@redirectToProvider']);
    Route::get('auth/github', 'GithubController@handleProviderCallback');
});

// Users
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@show']);
Route::get('user/{username}', ['as' => 'profile', 'uses' => 'ProfileController@show']);
Route::get('avatar/{username}', ['as' => 'avatar', 'uses' => 'ProfileController@avatar']);

// Settings
Route::get('settings', ['as' => 'settings.profile', 'uses' => 'Settings\ProfileController@edit']);
Route::put('settings', ['as' => 'settings.profile.update', 'uses' => 'Settings\ProfileController@update']);
Route::get('settings/password', ['as' => 'settings.password', 'uses' => 'Settings\PasswordController@edit']);
Route::put('settings/password', ['as' => 'settings.password.update', 'uses' => 'Settings\PasswordController@update']);

// Forum
Route::group(['prefix' => 'forum', 'namespace' => 'Forum'], function () {
    Route::get('/', ['as' => 'forum', 'uses' => 'ThreadsController@overview']);
    Route::get('create-thread', ['as' => 'threads.create', 'uses' => 'ThreadsController@create']);
    Route::post('create-thread', ['as' => 'threads.store', 'uses' => 'ThreadsController@store']);

    Route::get('{thread}', ['as' => 'thread', 'uses' => 'ThreadsController@show']);
    Route::get('{thread}/edit', ['as' => 'threads.edit', 'uses' => 'ThreadsController@edit']);
    Route::put('{thread}', ['as' => 'threads.update', 'uses' => 'ThreadsController@update']);
    Route::delete('{thread}', ['as' => 'threads.delete', 'uses' => 'ThreadsController@delete']);
    Route::put('{thread}/mark-solution/{reply}', ['as' => 'threads.solution.mark', 'uses' => 'ThreadsController@markSolution']);
    Route::put('{thread}/unmark-solution', ['as' => 'threads.solution.unmark', 'uses' => 'ThreadsController@unmarkSolution']);
    Route::get('{thread}/subscribe', ['as' => 'threads.subscribe', 'uses' => 'ThreadsController@subscribe']);
    Route::get('{thread}/unsubscribe', ['as' => 'threads.unsubscribe', 'uses' => 'ThreadsController@unsubscribe']);

    Route::get('tags/{tag}', ['as' => 'forum.tag', 'uses' => 'TagsController@show']);
});

// Replies
Route::post('replies', ['as' => 'replies.store', 'uses' => 'ReplyController@store']);
Route::get('replies/{reply}/edit', ['as' => 'replies.edit', 'uses' => 'ReplyController@edit']);
Route::put('replies/{reply}', ['as' => 'replies.update', 'uses' => 'ReplyController@update']);
Route::delete('replies/{reply}', ['as' => 'replies.delete', 'uses' => 'ReplyController@delete']);

// Subscriptions
Route::get('subscriptions/{subscription}/unsubscribe', ['as' => 'subscriptions.unsubscribe', 'uses' => 'SubscriptionController@unsubscribe']);

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::get('users/{username}', ['as' => '.users.show', 'uses' => 'UsersController@show']);
    Route::put('users/{username}/ban', ['as' => '.users.ban', 'uses' => 'UsersController@ban']);
    Route::put('users/{username}/unban', ['as' => '.users.unban', 'uses' => 'UsersController@unban']);
    Route::delete('users/{username}', ['as' => '.users.delete', 'uses' => 'UsersController@delete']);
});
