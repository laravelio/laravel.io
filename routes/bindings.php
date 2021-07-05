<?php

use Illuminate\Support\Facades\Route;

$uuid = '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}';

Route::bind('email_address', function (string $emailAddress) {
    return App\Models\User::findByEmailAddress($emailAddress);
});
Route::bind('reply', function (string $id) {
    return App\Models\Reply::findOrFail($id);
});
Route::bind('subscription', function (string $uuid) {
    return App\Models\Subscription::findByUuidOrFail(Ramsey\Uuid\Uuid::fromString($uuid));
});
Route::pattern('subscription', $uuid);
Route::bind('tag', function (string $slug) {
    return App\Models\Tag::findBySlug($slug);
});
Route::bind('thread', function (string $slug) {
    return App\Models\Thread::findBySlug($slug);
});
Route::bind('username', function (string $username) {
    return App\Models\User::findByUsername($username);
});
Route::bind('article', function (string $slug) {
    return App\Models\Article::findBySlug($slug);
});
