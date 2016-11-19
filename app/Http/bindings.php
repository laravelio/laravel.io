<?php

use App\Forum\ThreadRepository;
use App\Forum\TopicRepository;
use App\Replies\ReplyRepository;
use App\Tags\TagRepository;
use App\Users\UserRepository;

Route::bind('reply', function($id) {
    return app(ReplyRepository::class)->find($id);
});

Route::bind('tag', function($slug) {
    return app(TagRepository::class)->findBySlug($slug);
});

Route::bind('thread', function($slug) {
    return app(ThreadRepository::class)->findBySlug($slug);
});

Route::bind('topic', function($slug) {
    return app(TopicRepository::class)->findBySlug($slug);
});

Route::bind('username', function($username) {
    return app(UserRepository::class)->findByUsername($username);
});

Route::bind('email_address', function($emailAddress) {
    return app(UserRepository::class)->findByEmailAddress($emailAddress);
});
