<?php

Route::feeds();

// Home
Route::get('/', 'HomeController@show')->name('home');
Route::get('rules', 'HomeController@rules')->name('rules');
Route::get('terms', 'HomeController@terms')->name('terms');
Route::get('privacy', 'HomeController@privacy')->name('privacy');
Route::get('bin/{paste?}', 'HomeController@pastebin');

// Authentication
Route::namespace('Auth')->group(function () {
    // Sessions
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login.post');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register')->name('register.post');

    // Password reset
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.forgot');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.forgot.post');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset.post');

    // Email address confirmation
    Route::get('email-confirmation', 'EmailConfirmationController@send')->name('email.send_confirmation');
    Route::get('email-confirmation/{email_address}/{code}', 'EmailConfirmationController@confirm')
        ->name('email.confirm');

    // Social authentication
    Route::get('login/github', 'GithubController@redirectToProvider')->name('login.github');
    Route::get('auth/github', 'GithubController@handleProviderCallback');
});

// Users
Route::get('dashboard', 'DashboardController@show')->name('dashboard');
Route::get('user/{username}', 'ProfileController@show')->name('profile');
Route::get('avatar/{username}', 'ProfileController@avatar')->name('avatar');

// Settings
Route::get('settings', 'Settings\ProfileController@edit')->name('settings.profile');
Route::put('settings', 'Settings\ProfileController@update')->name('settings.profile.update');
Route::delete('settings', 'Settings\ProfileController@destroy')->name('settings.profile.delete');
Route::get('settings/password', 'Settings\PasswordController@edit')->name('settings.password');
Route::put('settings/password', 'Settings\PasswordController@update')->name('settings.password.update');

// Forum
Route::prefix('forum')->namespace('Forum')->group(function () {
    Route::get('/', 'ThreadsController@overview')->name('forum');
    Route::get('create-thread', 'ThreadsController@create')->name('threads.create');
    Route::post('create-thread', 'ThreadsController@store')->name('threads.store');

    Route::get('{thread}', 'ThreadsController@show')->name('thread');
    Route::get('{thread}/edit', 'ThreadsController@edit')->name('threads.edit');
    Route::put('{thread}', 'ThreadsController@update')->name('threads.update');
    Route::delete('{thread}', 'ThreadsController@delete')->name('threads.delete');
    Route::put('{thread}/mark-solution/{reply}', 'ThreadsController@markSolution')->name('threads.solution.mark');
    Route::put('{thread}/unmark-solution', 'ThreadsController@unmarkSolution')->name('threads.solution.unmark');
    Route::get('{thread}/subscribe', 'ThreadsController@subscribe')->name('threads.subscribe');
    Route::get('{thread}/unsubscribe', 'ThreadsController@unsubscribe')->name('threads.unsubscribe');

    Route::get('tags/{tag}', 'TagsController@show')->name('forum.tag');
});

// Replies
Route::post('replies', 'ReplyController@store')->name('replies.store');
Route::get('replies/{reply}/edit', 'ReplyController@edit')->name('replies.edit');
Route::put('replies/{reply}', 'ReplyController@update')->name('replies.update');
Route::delete('replies/{reply}', 'ReplyController@delete')->name('replies.delete');

// Subscriptions
Route::get('subscriptions/{subscription}/unsubscribe', 'SubscriptionController@unsubscribe')
    ->name('subscriptions.unsubscribe');

// Admin
Route::prefix('admin')->name('admin')->namespace('Admin')->group(function () {
    Route::get('/', 'AdminController@index');
    Route::get('users/{username}', 'UsersController@show')->name('.users.show');
    Route::put('users/{username}/ban', 'UsersController@ban')->name('.users.ban');
    Route::put('users/{username}/unban', 'UsersController@unban')->name('.users.unban');
    Route::delete('users/{username}', 'UsersController@delete')->name('.users.delete');
});
