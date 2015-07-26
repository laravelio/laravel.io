<?php

Route::group(['domain' => 'bin.laravel.io'], function() {
    Route::get('{wildcard}', function($wildcard) {
        return Redirect::to('http://laravel.io/bin/' . $wildcard);
    });
});
Route::group(['domain' => 'paste.laravel.io'], function() {
    Route::get('{wildcard}', function($wildcard) {
        return Redirect::to('http://laravel.io/bin/' . $wildcard);
    });
});
Route::group(['domain' => 'wiki.laravel.io'], function() {
    Route::get('{wildcard}', function($wildcard) {
        return Redirect::to('http://laravel.io/');
    });
});
Route::group(['domain' => 'forum.laravel.io'], function() {
    Route::get('{wildcard}', function($wildcard) {
        return Redirect::to('http://laravel.io/');
    });
});
Route::group(['domain' => 'forums.laravel.io'], function() {
    Route::get('{wildcard}', function($wildcard) {
        return Redirect::to('http://laravel.io/');
    });
});

Route::get('/', ['as' => 'home', 'uses' => function () {
    return redirect()->action('Forum\ForumThreadsController@getIndex');
}]);
Route::get('rss', function () {
    return redirect()->home();
});

// Auth
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::get('auth/github', 'AuthController@authByGithub');
    Route::get('signup', ['as' => 'signup', 'uses' => 'AuthController@signup']);
    Route::post('signup', 'AuthController@register');
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

    Route::get('confirm-email/{confirmation_code}', ['as' => 'auth.confirm', 'uses' => 'AuthController@confirmEmail']);
    Route::get('resend-email-confirmation', ['as' => 'auth.reconfirm', 'uses' => 'AuthController@resendEmailConfirmation']);

    // Keep to maintain backwards compatibility with sent emails.
    Route::get('signup/confirm-email/{confirmation_code}', function ($code) {
        return redirect()->route('auth.confirm', $code);
    });
});

// user profile
Route::get('user/{userSlug}', ['as' => 'user', 'uses' => 'UsersController@getProfile']);
Route::get('user/{userSlug}/threads', 'UsersController@getThreads');
Route::get('user/{userSlug}/replies', 'UsersController@getReplies');

Route::group(['middleware' => 'auth'], function () {
    Route::get('user/{userSlug}/settings', ['as' => 'user.settings', 'uses' => 'UsersController@getSettings']);
    Route::put('user/{userSlug}/settings', ['as' => 'user.settings.update', 'uses' => 'UsersController@putSettings']);
});

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

Route::group(['middleware' => ['auth', 'confirmed']], function() {
    Route::post('bin', 'PastesController@postCreate');
    Route::post('bin/fork/{hash}', 'PastesController@postFork');
});

// forum
Route::group(['namespace' => 'Forum'], function() {
    Route::group(['middleware' => ['auth', 'confirmed']], function() {
        Route::get('forum/create-thread', 'ForumThreadsController@getCreateThread');
        Route::post('forum/create-thread', 'ForumThreadsController@postCreateThread');

        Route::get('forum/mark-as-solved/{threadId}/{replyId}', 'ForumThreadsController@getMarkQuestionSolved');
        Route::get('forum/mark-as-unsolved/{threadId}', 'ForumThreadsController@getMarkQuestionUnsolved');

        Route::get('forum/edit-thread/{threadId}', 'ForumThreadsController@getEditThread');
        Route::post('forum/edit-thread/{threadId}', 'ForumThreadsController@postEditThread');
        Route::get('forum/edit-reply/{replyId}', 'ForumRepliesController@getEditReply');
        Route::post('forum/edit-reply/{replyId}', 'ForumRepliesController@postEditReply');

        Route::get('forum/delete/reply/{replyId}', 'ForumRepliesController@getDelete');
        Route::post('forum/delete/reply/{replyId}', 'ForumRepliesController@postDelete');
        Route::get('forum/delete/thread/{threadId}', 'ForumThreadsController@getDelete');
        Route::post('forum/delete/thread/{threadId}', 'ForumThreadsController@postDelete');

        Route::post('forum/{slug}', 'ForumRepliesController@postCreateReply');
    });

    Route::get('forum/{status?}', 'ForumThreadsController@getIndex')
        ->where(['status' => '(open|solved)']);

    Route::get('forum/search', 'ForumThreadsController@getSearch');
    Route::get('forum/{slug}/reply/{reply}', 'ForumRepliesController@getReplyRedirect');
    Route::get('forum/{slug}', 'ForumThreadsController@getShowThread');
});

// admin
Route::group(['middleware' => ['auth', 'confirmed'], 'before' => 'has_role:manage_users', 'prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', function() {
        return redirect()->route('admin.users');
    });

    Route::get('users', ['as' => 'admin.users', 'uses' => 'UsersController@getIndex']);
    Route::get('users/search', ['as' => 'admin.users.search', 'uses' => 'UsersController@search']);
    Route::get('edit/{user}', 'UsersController@getEdit');
    Route::post('edit/{user}', 'UsersController@postEdit');
    Route::put('ban-and-delete-threads/{user}', 'UsersController@putBanAndDeleteThreads');
});
