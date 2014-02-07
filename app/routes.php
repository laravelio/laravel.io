<?php

Route::group(array('domain' => 'bin.laravel.io'), function() {
    Route::get('{wildcard}', function($wildcard) {
        return Redirect::to('http://laravel.io/bin/' . $wildcard);
    });
});
Route::group(array('domain' => 'paste.laravel.io'), function() {
    Route::get('{wildcard}', function($wildcard) {
        return Redirect::to('http://laravel.io/bin/' . $wildcard);
    });
});

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
//Route::get('dashboard/articles', ['before' => 'auth', 'uses' => 'ArticlesController@getDashboard']);

// user profile
Route::get('user/{userSlug}', 'UsersController@getProfile');

// contributors
Route::get('contributors', 'ContributorsController@getIndex');

// chat
Route::get('chat', 'ChatController@getIndex');
// chat legacy
Route::get('irc', function() {
    return Redirect::action('ChatController@getIndex');
});

// paste bin
Route::get('bin', 'BinController@getCreate');
Route::post('bin', 'BinController@postCreate');
Route::get('bin/fork/{hash}', 'BinController@getFork');
Route::post('bin/fork/{hash}', 'BinController@postFork');
Route::get('bin/{hash}/raw', 'BinController@getRaw');
Route::get('bin/{hash}', 'BinController@getShow');

// articles
// Route::get('articles', 'ArticlesController@getIndex');
// Route::get('article/{slug}/edit-comment/{commentId}', ['before' => 'auth', 'uses' => 'ArticlesController@getEditComment']);
// Route::post('article/{slug}/edit-comment/{commentId}', ['before' => 'auth', 'uses' => 'ArticlesController@postEditComment']);
// Route::get('article/{slug}/delete-comment/{commentId}', ['before' => 'auth', 'uses' => 'ArticlesController@getDeleteComment']);
// Route::post('article/{slug}/delete-comment/{commentId}', ['before' => 'auth', 'uses' => 'ArticlesController@postDeleteComment']);
// Route::get('article/{slug}', ['before' => '', 'uses' => 'ArticlesController@getShow']);
// Route::post('article/{slug}', ['before' => '', 'uses' => 'ArticlesController@postShow']);
// Route::get('articles/compose', ['before' => 'auth', 'uses' => 'ArticlesController@getCompose']);
// Route::post('articles/compose', ['before' => 'auth', 'uses' => 'ArticlesController@postCompose']);
// Route::get('articles/edit/{article}', ['before' => 'auth', 'uses' => 'ArticlesController@getEdit']);
// Route::post('articles/edit/{article}', ['before' => 'auth', 'uses' => 'ArticlesController@postEdit']);
// Route::get('articles/search', 'ArticlesController@getSearch');

// forum
Route::group(['before' => 'auth'], function() {
    Route::get('forum/create-thread', 'ForumThreadsController@getCreateThread');
    Route::post('forum/create-thread', 'ForumThreadsController@postCreateThread');

    Route::get('forum/mark-as-solved/{threadId}', 'ForumThreadsController@getMarkQuestionSolved');

    Route::get('forum/edit-thread/{threadId}', 'ForumThreadsController@getEditThread');
    Route::post('forum/edit-thread/{threadId}', 'ForumThreadsController@postEditThread');
    Route::get('forum/edit-reply/{replyId}', 'ForumRepliesController@getEditReply');
    Route::post('forum/edit-reply/{replyId}', 'ForumRepliesController@postEditReply');

    Route::get('forum/delete/reply/{replyId}', 'ForumRepliesController@getDelete');
    Route::post('forum/delete/reply/{replyId}', 'ForumRepliesController@postDelete');
    Route::get('forum/delete/thread/{threadId}', 'ForumThreadsController@getDelete');
    Route::post('forum/delete/thread/{threadId}', 'ForumThreadsController@postDelete');

    Route::post('forum/{slug}', ['before' => '', 'uses' => 'ForumRepliesController@postCreateReply']);
});
Route::get('forum', 'ForumThreadsController@getIndex');
Route::get('forum/search', 'ForumThreadsController@getSearch');
Route::get('forum/{slug}/reply/{commentId}', 'ForumRepliesController@getReplyRedirect');
Route::get('forum/{slug}', ['before' => '', 'uses' => 'ForumThreadsController@getShowThread']);

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
