<?php

use App\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => true,
        'confirmation_code' => $faker->md5,
        'github_id' => $faker->numberBetween(10000, 99999),
        'github_username' => $faker->userName,
        'ip' => $faker->ipv4,
        'banned_at' => null,
        'type' => User::DEFAULT,
        'bio' => $faker->sentence,
    ];
});

$factory->state(User::class, 'passwordless', function () {
    return [
        'password' => '',
    ];
});
