<?php

Route::get('/', 'Controllers\HomeController@getIndex');

// authentication
Route::get('login', 'Controllers\AuthController@getLogin');
Route::get('signup', 'Controllers\AuthController@getSignup');
Route::get('signup-confirm', 'Controllers\AuthController@getSignupConfirm');
Route::post('signup-confirm', 'Controllers\AuthController@postSignupConfirm');
Route::get('logout', 'Controllers\AuthController@getLogout');
Route::get('oauth', 'Controllers\AuthController@getOauth');

// user dashboard
Route::get('dashboard', ['before' => 'auth', 'uses' => 'Controllers\DashboardController@getIndex']);
Route::get('dashboard/articles', ['before' => 'auth', 'uses' => 'Controllers\ArticlesController@getDashboard']);

// user profile
Route::get('user/{userSlug}', ['before' => 'auth', 'uses' => 'Controllers\UsersController@getProfile']);

// chat
Route::get('contributors', 'Controllers\ContributorsController@getIndex');

// chat
Route::get('chat', 'Controllers\ChatController@getIndex');

// pastes
Route::get('bin', 'Controllers\PastesController@getCreate');

// articles
Route::get('articles', 'Controllers\ArticlesController@getIndex');
Route::get('article/{slug}', ['before' => 'handle_slug', 'uses' => 'Controllers\ArticlesController@getShow']);
Route::get('articles/compose', ['before' => 'auth', 'uses' => 'Controllers\ArticlesController@getCompose']);
Route::post('articles/compose', ['before' => 'auth', 'uses' => 'Controllers\ArticlesController@postCompose']);
Route::get('articles/edit/{article}', ['before' => 'auth', 'uses' => 'Controllers\ArticlesController@getEdit']);
Route::post('articles/edit/{article}', ['before' => 'auth', 'uses' => 'Controllers\ArticlesController@postEdit']);

// forum
Route::get('forum', 'Controllers\ForumController@getIndex');
Route::get('forum/{forumCategory}', 'Controllers\ForumController@getCategory');
Route::get('forum/create-thread', ['before' => 'auth', 'uses' => 'Controllers\ForumController@getCreateThread']);
Route::post('forum/create-thread', ['before' => 'auth', 'uses' => 'Controllers\ForumController@postCreateThread']);
Route::get('forum/{forumCategory}/{slug}', ['before' => 'handle_slug', 'uses' => 'Controllers\ForumController@getThread']);
Route::post('forum/{forumCategory}/{slug}', ['before' => 'auth|handle_slug', 'uses' => 'Controllers\ForumController@postThread']);

// admin
Route::group(['before' => 'auth', 'prefix' => 'admin'], function() {
	// users
    Route::group(['before' => 'has_role:admin_users'], function() {
    	Route::get('users', 'Controllers\Admin\UsersController@getIndex');
        Route::get('edit/{user}', 'Controllers\Admin\UsersController@getEdit');
        Route::post('edit/{user}', 'Controllers\Admin\UsersController@postEdit');
    });
});
