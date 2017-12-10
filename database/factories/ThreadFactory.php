<?php

use App\User;
use App\Models\Thread;

$factory->define(Thread::class, function (Faker\Generator $faker, array $attributes = []) {
    return [
        'subject' => $faker->text(20),
        'body' => $faker->text,
        'slug' => $faker->slug,
        'author_id' => $attributes['author_id'] ?? factory(User::class)->create()->id(),
        'ip' => $faker->ipv4,
    ];
});
