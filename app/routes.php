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
Route::get('rss', function () {
    return Redirect::home();
});

// authentication
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
Route::get('login-required', 'AuthController@getLoginRequired');
Route::get('signup-confirm', 'AuthController@getSignupConfirm');
Route::post('signup-confirm', ['before' => 'csrf', 'uses' => 'AuthController@postSignupConfirm']);
Route::get('logout', 'AuthController@getLogout');
Route::get('oauth', 'AuthController@getOauth');
Route::get('signup/confirm-email/{confirmation_code}', ['as' => 'user.confirm', 'uses' => 'AuthController@getConfirmEmail']);
Route::get('signup/resend-confirmation/{confirmation_code}', ['as' => 'user.reconfirm', 'uses' => 'AuthController@getResendConfirmation']);

// user dashboard
//Route::get('dashboard', ['before' => 'auth', 'uses' => 'DashboardController@getIndex']);
//Route::get('dashboard/articles', ['before' => 'auth', 'uses' => 'ArticlesController@getDashboard']);

// user profile
Route::get('user/{userSlug}', ['as' => 'user', 'uses' => 'UsersController@getProfile']);
Route::get('user/{userSlug}/threads', 'UsersController@getThreads');
Route::get('user/{userSlug}/replies', 'UsersController@getReplies');

Route::group(['before' => 'auth'], function () {
    Route::get('user/{userSlug}/settings', ['as' => 'user.settings', 'uses' => 'UsersController@getSettings']);
    Route::put('user/{userSlug}/settings', ['before' => 'csrf', 'as' => 'user.settings.update', 'uses' => 'UsersController@putSettings']);
});

// contributors
Route::get('contributors', 'ContributorsController@getIndex');

// chat
Route::get('chat', 'ChatController@getIndex');
// chat legacy
Route::get('irc', function() {
    return Redirect::action('ChatController@getIndex');
});

// paste bin
Route::get('bin', 'PastesController@getCreate');
Route::get('bin/fork/{hash}', 'PastesController@getFork');
Route::get('bin/{hash}/raw', 'PastesController@getRaw');
Route::get('bin/{hash}', 'PastesController@getShow');

Route::group(['before' => 'auth|confirmed'], function() {
    Route::post('bin', ['before' => 'csrf', 'uses' => 'PastesController@postCreate']);
    Route::post('bin/fork/{hash}', ['before' => 'csrf', 'uses' => 'PastesController@postFork']);
});

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
Route::group(['before' => 'auth|confirmed'], function() {
    Route::get('forum/create-thread', 'ForumThreadsController@getCreateThread');
    Route::post('forum/create-thread', ['before' => 'csrf', 'uses' => 'ForumThreadsController@postCreateThread']);

    Route::get('forum/mark-as-solved/{threadId}/{replyId}', 'ForumThreadsController@getMarkQuestionSolved');
    Route::get('forum/mark-as-unsolved/{threadId}', 'ForumThreadsController@getMarkQuestionUnsolved');

    Route::get('forum/edit-thread/{threadId}', 'ForumThreadsController@getEditThread');
    Route::post('forum/edit-thread/{threadId}', 'ForumThreadsController@postEditThread');
    Route::get('forum/edit-reply/{replyId}', 'ForumRepliesController@getEditReply');
    Route::post('forum/edit-reply/{replyId}', ['before' => 'csrf', 'uses' => 'ForumRepliesController@postEditReply']);

    Route::get('forum/delete/reply/{replyId}', 'ForumRepliesController@getDelete');
    Route::post('forum/delete/reply/{replyId}', 'ForumRepliesController@postDelete');
    Route::get('forum/delete/thread/{threadId}', 'ForumThreadsController@getDelete');
    Route::post('forum/delete/thread/{threadId}', 'ForumThreadsController@postDelete');

    Route::post('forum/{slug}', ['before' => 'csrf', 'uses' => 'ForumRepliesController@postCreateReply']);
});

Route::get('forum/{status?}', ['as' => 'home', 'uses' => 'ForumThreadsController@getIndex'])
    ->where(array('status' => '(|open|solved)'));

Route::get('forum/search', 'ForumThreadsController@getSearch');
Route::get('forum/{slug}/reply/{commentId}', 'ForumRepliesController@getReplyRedirect');
Route::get('forum/{slug}', ['before' => '', 'uses' => 'ForumThreadsController@getShowThread']);

Route::get('api/forum', 'Api\ForumThreadsController@getIndex');

// admin
Route::group(['before' => 'auth|confirmed', 'prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', function() {
        return Redirect::action('Admin\UsersController@getIndex');
    });

    Route::group(['before' => 'has_role:manage_users'], function() {
        Route::get('users', 'UsersController@getIndex');
        Route::get('edit/{user}', 'UsersController@getEdit');
        Route::post('edit/{user}', 'UsersController@postEdit');
        Route::put('ban-and-delete-threads/{user}', 'UsersController@putBanAndDeleteThreads');
    });
});
