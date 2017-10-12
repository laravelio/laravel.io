<?php

use App\Models\Thread;
use App\User;

$factory->define(Thread::class, function (Faker\Generator $faker) {
    return [
        'subject' => $faker->text(20),
        'body' => $faker->text,
        'slug' => $faker->slug,
        'author_id' => factory(User::class)->create()->id(),
        'ip' => $faker->ipv4,
    ];
});
