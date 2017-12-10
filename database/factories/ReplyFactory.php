<?php

use App\User;
use App\Models\Reply;
use App\Models\Thread;

$factory->define(Reply::class, function (Faker\Generator $faker, array $attributes = []) {
    return [
        'body' => $faker->text(),
        'author_id' => $attributes['author_id'] ?? factory(User::class)->create()->id(),
        'replyable_id' =>  $attributes['replyable_id'] ?? factory(Thread::class)->create()->id(),
        'replyable_type' => Thread::TABLE,
        'ip' => $faker->ipv4,
    ];
});
