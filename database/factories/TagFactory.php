<?php

use App\Models\Tag;

$factory->define(Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(15),
        'slug' => $faker->slug,
    ];
});
