<?php

namespace Database\Factories;

use App\Models\Series;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

class SeriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Series::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => function () {
                return User::factory()->create()->id;
            },
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
        ];
    }
}
