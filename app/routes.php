<?php

Route::get('/', 'HomeController@getIndex');

// authentication
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
Route::get('login-required', 'AuthController@getLoginRequired');
Route::get('signup-confirm', 'AuthController@getSignupConfirm');
Route::post('signup-confirm', 'AuthController@postSignupConfirm');
Route::get('logout', 'AuthController@getLogout');
Route::get('oauth', 'AuthController@getOauth');

// user dashboard
Route::get('dashboard', ['before' => 'auth', 'uses' => 'DashboardController@getIndex']);
Route::get('dashboard/articles', ['before' => 'auth', 'uses' => 'ArticlesController@getDashboard']);

// user profile
Route::get('user/{userSlug}', 'UsersController@getProfile');

// chat
Route::get('contributors', 'ContributorsController@getIndex');

// chat
Route::get('chat', 'ChatController@getIndex');

// pastes
Route::get('bin', 'PastesController@getCreate');

// articles
Route::get('articles', 'ArticlesController@getIndex');
Route::get('article/{slug}/edit-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@getEditComment']);
Route::post('article/{slug}/edit-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@postEditComment']);
Route::get('article/{slug}/delete-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@getDeleteComment']);
Route::post('article/{slug}/delete-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@postDeleteComment']);
Route::get('article/{slug}', ['before' => 'handle_slug', 'uses' => 'ArticlesController@getShow']);
Route::post('article/{slug}', ['before' => 'handle_slug', 'uses' => 'ArticlesController@postShow']);
Route::get('articles/compose', ['before' => 'auth', 'uses' => 'ArticlesController@getCompose']);
Route::post('articles/compose', ['before' => 'auth', 'uses' => 'ArticlesController@postCompose']);
Route::get('articles/edit/{article}', ['before' => 'auth', 'uses' => 'ArticlesController@getEdit']);
Route::post('articles/edit/{article}', ['before' => 'auth', 'uses' => 'ArticlesController@postEdit']);
Route::get('articles/search', 'ArticlesController@getSearch');

// forum
Route::get('forum', 'ForumController@getIndex');
Route::get('forum/search', 'ForumController@getSearch');

// move to new controller
Route::get('forum/{slug}/comment/{commentId}', 'ForumController@getCommentRedirect');

Route::group(['before' => 'auth'], function() {
    Route::get('forum/create-thread', 'ForumController@getCreateThread');
    Route::post('forum/create-thread', 'ForumController@postCreateThread');
    Route::get('forum/edit-thread/{threadId}', 'ForumController@getEditThread');
    Route::post('forum/edit-thread/{threadId}', 'ForumController@postEditThread');
    Route::get('forum/edit-reply/{commentId}', 'ForumReplyController@edit');
    Route::post('forum/edit-reply/{commentId}', 'ForumReplyController@update');

    // move to new controller
    Route::get('forum/delete/{commentId}', 'ForumController@getDeleteThread');
    Route::post('forum/delete/{commentId}', 'ForumController@postDeleteThread');

    Route::post('forum/{slug}', ['before' => 'handle_slug', 'uses' => 'ForumReplyController@store']);
});

Route::get('forum/{slug}', ['before' => 'handle_slug', 'uses' => 'ForumController@getShowThread']);

// admin
Route::group(['before' => 'auth', 'prefix' => 'admin'], function() {

    Route::get('/', function() {
        return Redirect::action('Admin\UsersController@getIndex');
    });

	// users
    Route::group(['before' => 'has_role:admin_users'], function() {
    	Route::get('users', 'Admin\UsersController@getIndex');
        Route::get('edit/{user}', 'Admin\UsersController@getEdit');
        Route::post('edit/{user}', 'Admin\UsersController@postEdit');
    });
});
