<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(3, true),
            'slug' => $this->faker->unique()->slug,
        ];
    }
}
