<?php

use App\Models\Thread;
use App\User;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Thread::class, function (Faker\Generator $faker, array $attributes = []) {
    return [
        'subject' => $faker->text(20),
        'body' => $faker->text,
        'slug' => $faker->unique()->slug,
        'author_id' => $attributes['author_id'] ?? factory(User::class)->create()->id(),
    ];
});

$factory->state(Thread::class, 'old', [
    'created_at' => now()->subMonths(7),
]);
