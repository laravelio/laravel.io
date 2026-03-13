<?php

use App\Models\Article;
use App\Models\Reply;
use App\Models\Subscription;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

$uuid = '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}';

Route::bind('email_address', function (string $emailAddress) {
    return User::findByEmailAddress($emailAddress);
});
Route::bind('reply', function (string $id) {
    return Reply::findOrFail($id);
});
Route::bind('subscription', function (string $uuid) {
    return Subscription::findByUuidOrFail(Uuid::fromString($uuid));
});
Route::pattern('subscription', $uuid);
Route::bind('tag', function (string $slug) {
    return Tag::findBySlug($slug);
});
Route::bind('thread', function (string $slug) {
    return Thread::findBySlug($slug);
});
Route::bind('username', function (string $username) {
    return User::findByUsername($username);
});
Route::bind('article', function (string $slug) {
    return Article::findBySlug($slug);
});
