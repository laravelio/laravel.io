<?php

use App\Models\Series;
use App\User;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Series::class, function (Faker $faker) {
    return [
        'author_id' => function () {
            return factory(User::class)->create()->id;
        },
        'title' => $faker->word,
        'slug' => $faker->unique()->slug,
    ];
});
