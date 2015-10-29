<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Lio\Forum\EloquentThread;
use Lio\Users\EloquentUser;

$factory->define(EloquentUser::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'username' => $faker->userName,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'confirmed' => true,
        'github_url' => $faker->userName,
    ];
});

$factory->define(EloquentThread::class, function (Faker\Generator $faker) {
    return [
        'subject' => $faker->title,
        'body' => $faker->text,
        'slug' => $faker->slug,
        'author_id' => factory(EloquentUser::class)->create()->id(),
        'laravel_version' => $faker->randomElement([3, 4, 5]),
    ];
});
