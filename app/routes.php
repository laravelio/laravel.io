<?php

Route::get('add', function() {

});

Route::get('show', function() {
    $user = Lio\Accounts\User::find(1);
    return $user->notifications;
});

// pastebin redirections
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

// landing page
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

// contributors
Route::get('contributors', 'ContributorsController@getIndex');

// chat
Route::get('chat', 'ChatController@getIndex');
// chat legacy redirect
Route::get('irc', function() {
    return Redirect::action('ChatController@getIndex');
});

// paste bin
Route::get('bin', 'BinController@getCreate');
Route::post('bin', ['before' => 'csrf', 'uses' => 'BinController@postCreate']);
Route::get('bin/{hash}', 'BinController@getShow');
Route::get('bin/fork/{hash}', 'BinController@getFork');
Route::post('bin/fork/{hash}', ['before' => 'csrf', 'uses' => 'BinController@postFork']);
Route::get('bin/{hash}/raw', 'BinController@getRaw');

// articles
Route::get('articles', 'ArticlesController@getIndex');
Route::get('article/{slug}', 'Controllers\Articles\ShowArticleController@getShow');

Route::group(['before' => 'auth'], function() {
    // create
    Route::get('articles/compose', 'Controllers\Articles\CreateArticleController@getCreate');
    Route::post('articles/compose', 'Controllers\Articles\CreateArticleController@postCreate');

    // update
    Route::get('articles/edit/{id}', 'Controllers\Articles\UpdateArticleController@getUpdate');
    Route::post('articles/edit/{id}', 'Controllers\Articles\UpdateArticleController@postUpdate');

    // delete
    Route::get('articles/delete/{id}', 'Controllers\Articles\DeleteArticleController@getDelete');
    Route::post('articles/delete/{id}', 'Controllers\Articles\DeleteArticleController@postDelete');
});


Route::get('articles/search', 'ArticlesController@getSearch');

// forum
Route::group(['before' => 'auth'], function() {
    Route::get('forum/create-thread', 'ForumThreadsController@getCreate');
    Route::post('forum/create-thread', 'ForumThreadsController@postCreate');

    Route::get('forum/mark-as-solved/{threadId}/{replyId}', 'ForumThreadsController@getMarkThreadSolved');
    Route::get('forum/mark-as-unsolved/{threadId}', 'ForumThreadsController@getMarkThreadUnsolved');

    Route::get('forum/update-thread/{threadId}', 'ForumThreadsController@getUpdate');
    Route::post('forum/update-thread/{threadId}', 'ForumThreadsController@postUpdate');
    Route::get('forum/edit-reply/{replyId}', 'ForumRepliesController@getUpdate');
    Route::post('forum/edit-reply/{replyId}', 'ForumRepliesController@postUpdate');

    Route::get('forum/delete/reply/{replyId}', 'ForumRepliesController@getDelete');
    Route::post('forum/delete/reply/{replyId}', 'ForumRepliesController@postDelete');
    Route::get('forum/delete/thread/{threadId}', 'ForumThreadsController@getDelete');
    Route::post('forum/delete/thread/{threadId}', 'ForumThreadsController@postDelete');

    Route::post('forum/{slug}', 'ForumRepliesController@postCreate');
});

Route::get('forum/{status?}', 'ForumThreadsController@getIndex')
    ->where(array('status' => '(|open|solved)'));

Route::get('forum/search', 'ForumThreadsController@getSearch');
Route::get('forum/{slug}/reply/{replyId}', 'ForumRepliesController@getReplyRedirect');
Route::get('forum/{slug}', 'ForumThreadsController@getShow');

Route::get('api/forum', 'Api\ForumThreadsController@getIndex');

// admin
Route::group(['before' => 'auth', 'prefix' => 'admin'], function() {

    Route::get('/', function() {
        return Redirect::action('AdminUsersController@getIndex');
    });

	// users
    Route::group(['before' => 'has_role:manage_users'], function() {
    	Route::get('users', 'AdminUsersController@getIndex');
        Route::get('edit/{user}', 'AdminUsersController@getEdit');
        Route::post('edit/{user}', 'AdminUsersController@postEdit');
    });
});
