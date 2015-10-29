<?php

use Lio\Forum\ThreadRepository;
use Lio\Users\UserRepository;

Route::bind('thread_slug', function($slug) {
    return app(ThreadRepository::class)->findBySlug($slug) ?: abort(404);
});

Route::bind('username', function($username) {
    return app(UserRepository::class)->findByUsername($username) ?: abort(404);
});
