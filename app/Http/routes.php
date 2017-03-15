<?php

// Home
Route::group(['domain' => 'wiki.laravel.io'], function () {
    Route::get('{wildcard}', 'HomeController@redirectToMainWebsite');
});
Route::group(['domain' => 'forum.laravel.io'], function () {
    Route::get('{wildcard}', 'HomeController@redirectToMainWebsite');
});
Route::group(['domain' => 'forums.laravel.io'], function () {
    Route::get('{wildcard}', 'HomeController@redirectToMainWebsite');
});

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('rss', 'HomeController@rss');

// Auth
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::get('auth/github', 'AuthController@authByGithub');
    Route::get('signup', ['as' => 'signup', 'uses' => 'AuthController@signup']);
    Route::post('signup', 'AuthController@register');
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

    Route::get('confirm-email/{confirmation_code}', ['as' => 'auth.confirm', 'uses' => 'AuthController@confirmEmail']);
    Route::get('resend-email-confirmation', ['as' => 'auth.reconfirm', 'uses' => 'AuthController@resendEmailConfirmation']);
});

// Users
Route::get('user/{username}', ['as' => 'user', 'uses' => 'UsersController@getProfile']);
Route::get('user/{username}/threads', 'UsersController@getThreads');
Route::get('user/{username}/replies', 'UsersController@getReplies');

Route::group(['middleware' => 'auth'], function () {
    Route::get('user/{username}/settings', ['as' => 'user.settings', 'uses' => 'UsersController@getSettings']);
    Route::put('user/{username}/settings', ['as' => 'user.settings.update', 'uses' => 'UsersController@putSettings']);
});

// Chat
Route::get('chat', 'ChatController@getIndex');

// Paste Bin
Route::get('bin', 'PastesController@getCreate');
Route::get('bin/fork/{hash}', 'PastesController@getFork');
Route::get('bin/{hash}/raw', 'PastesController@getRaw');
Route::get('bin/{hash}', 'PastesController@getShow');

Route::group(['middleware' => ['auth', 'confirmed']], function () {
    Route::post('bin', 'PastesController@postCreate');
    Route::post('bin/fork/{hash}', 'PastesController@postFork');
});

// Forum
Route::group(['namespace' => 'Forum'], function () {
    Route::group(['middleware' => ['auth', 'confirmed']], function () {
        Route::get('forum/create-thread', 'ForumThreadsController@getCreateThread');
        Route::post('forum/create-thread', 'ForumThreadsController@postCreateThread');

        Route::get('forum/mark-as-solved/{thread}/{reply}', 'ForumThreadsController@getMarkQuestionSolved');
        Route::get('forum/mark-as-unsolved/{thread}', 'ForumThreadsController@getMarkQuestionUnsolved');

        Route::get('forum/edit-thread/{thread}', 'ForumThreadsController@getEditThread');
        Route::post('forum/edit-thread/{thread}', 'ForumThreadsController@postEditThread');
        Route::get('forum/edit-reply/{reply}', 'ForumRepliesController@getEditReply');
        Route::post('forum/edit-reply/{reply}', 'ForumRepliesController@postEditReply');

        Route::get('forum/delete/reply/{reply}', 'ForumRepliesController@getDelete');
        Route::post('forum/delete/reply/{reply}', 'ForumRepliesController@postDelete');
        Route::get('forum/delete/thread/{thread}', 'ForumThreadsController@getDelete');
        Route::post('forum/delete/thread/{thread}', 'ForumThreadsController@postDelete');

        Route::post('forum/{slug}', 'ForumRepliesController@postCreateReply');
    });

    Route::get('forum/{status?}', 'ForumThreadsController@getIndex')
        ->where(['status' => '(open|solved)']);

    Route::get('forum/search', 'ForumThreadsController@getSearch');
    Route::get('forum/{slug}/reply/{reply}', 'ForumRepliesController@getReplyRedirect');
    Route::get('forum/{slug}', 'ForumThreadsController@getShowThread');
});

// Admin
Route::group(['middleware' => ['auth', 'confirmed'], 'before' => 'has_role:manage_users', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'OverviewController@overview');

    Route::get('users', ['as' => 'admin.users', 'uses' => 'UsersController@getIndex']);
    Route::get('users/search', ['as' => 'admin.users.search', 'uses' => 'UsersController@search']);
    Route::get('edit/{user}', 'UsersController@getEdit');
    Route::post('edit/{user}', 'UsersController@postEdit');
    Route::put('ban-and-delete-threads/{user}', 'UsersController@putBanAndDeleteThreads');
});
