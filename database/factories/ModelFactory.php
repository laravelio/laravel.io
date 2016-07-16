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
use Lio\Replies\EloquentReply;
use Lio\Tags\EloquentTag;
use Lio\Users\EloquentUser;

$factory->define(EloquentUser::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'username' => $faker->userName,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'confirmed' => true,
        'github_url' => $faker->userName,
    ];
});

$factory->define(EloquentThread::class, function (Faker\Generator $faker) {
    return [
        'subject' => $faker->sentence,
        'body' => $faker->text,
        'slug' => $faker->slug,
        'author_id' => factory(EloquentUser::class)->create()->id(),
        'laravel_version' => $faker->randomElement([3, 4, 5]),
    ];
});

$factory->define(EloquentReply::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->title,
        'author_id' => factory(EloquentUser::class)->create()->id(),
        'replyable_id' => factory(EloquentThread::class)->create()->id(),
        'replyable_type' => EloquentThread::TYPE,
    ];
});

$factory->define(EloquentTag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->title,
        'slug' => $faker->slug,
        'description' => $faker->text,
    ];
});
