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

use App\Forum\Thread;
use App\Models\Topic;
use App\Replies\Reply;
use App\Models\Tag;
use App\User;

$factory->define(User::class, function (Faker\Generator $faker) {
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
        'is_banned' => false,
        'type' => User::DEFAULT,
    ];
});

$factory->define(Thread::class, function (Faker\Generator $faker) {
    return [
        'topic_id' => 1,
        'subject' => $faker->text(20),
        'body' => $faker->text,
        'slug' => $faker->slug,
        'author_id' => factory(User::class)->create()->id(),
        'ip' => $faker->ipv4,
    ];
});

$factory->define(Topic::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(20),
        'slug' => $faker->slug,
    ];
});

$factory->define(Reply::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->text(),
        'author_id' => factory(User::class)->create()->id(),
        'replyable_id' => factory(Thread::class)->create()->id(),
        'replyable_type' => Thread::TABLE,
        'ip' => $faker->ipv4,
    ];
});

$factory->define(Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(15),
        'slug' => $faker->slug,
        'description' => $faker->text,
    ];
});
