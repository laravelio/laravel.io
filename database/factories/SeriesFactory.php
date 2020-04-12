<?php

use App\Series;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {
    return [
        'author_id' => function () {
            return factory(User::class)->create()->id;
        },
        'title' => $faker->word,
    ];
});
