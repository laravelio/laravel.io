<?php

use App\Models\Like;
use App\Models\Reply;
use App\Models\Thread;
use App\User;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Like::class, function (Faker\Generator $faker, array $attributes = []) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->state(Like::class, 'reply', [
    'likeable_id' => function () {
        return factory(Reply::class)->create()->id;
    },
    'likeable_type' => 'replies',
]);

$factory->state(Like::class, 'thread', [
    'likeable_id' => function () {
        return factory(Thread::class)->create()->id;
    },
    'likeable_type' => 'threads',
]);
