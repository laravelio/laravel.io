<?php

use App\User;
use Illuminate\Support\Str;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
        'github_id' => $faker->numberBetween(10000, 99999),
        'github_username' => $faker->userName,
        'banned_at' => null,
        'type' => User::DEFAULT,
        'bio' => $faker->sentence,
        'email_verified_at' => now()->subDay(),
    ];
});

$factory->state(User::class, 'passwordless', function () {
    return [
        'password' => '',
    ];
});
