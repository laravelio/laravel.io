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

use App\Forum\EloquentThread;
use App\Forum\Topics\EloquentTopic;
use App\Replies\EloquentReply;
use App\Tags\EloquentTag;
use App\Users\EloquentUser;

$factory->define(EloquentUser::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'username' => $faker->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => true,
        'confirmation_code' => $faker->md5,
        'github_id' => $faker->numberBetween(10000, 99999),
        'github_url' => $faker->userName,
        'ip' => $faker->ipv4,
    ];
});

$factory->define(EloquentThread::class, function (Faker\Generator $faker) {
    return [
        'topic_id' => 1,
        'subject' => $faker->text(20),
        'body' => $faker->text,
        'slug' => $faker->slug,
        'author_id' => factory(EloquentUser::class)->create()->id(),
        'ip' => $faker->ipv6,
    ];
});

$factory->define(EloquentTopic::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(20),
        'slug' => $faker->slug,
    ];
});

$factory->define(EloquentReply::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->text(),
        'author_id' => factory(EloquentUser::class)->create()->id(),
        'replyable_id' => factory(EloquentThread::class)->create()->id(),
        'replyable_type' => EloquentThread::TYPE,
        'ip' => $faker->ipv6,
    ];
});

$factory->define(EloquentTag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(15),
        'slug' => $faker->slug,
        'description' => $faker->text,
    ];
});
