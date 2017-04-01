<?php

Route::bind('reply', function($id) {
    return App\Replies\Reply::findOrFail($id);
});

Route::bind('tag', function($slug) {
    return App\Models\Tag::findBySlug($slug);
});

Route::bind('thread', function($slug) {
    return App\Forum\Thread::findBySlug($slug);
});

Route::bind('topic', function($slug) {
    return App\Forum\Topic::findBySlug($slug);
});

Route::bind('username', function($username) {
    return App\User::findByUsername($username);
});

Route::bind('email_address', function($emailAddress) {
    return App\User::findByEmailAddress($emailAddress);
});
