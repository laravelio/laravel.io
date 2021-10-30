<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(3, true),
            'slug' => $this->faker->unique()->slug,
        ];
    }

    public function approved(): self
    {
        return $this->state(function (): array {
            return [
                'approved_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        });
    }

    public function unapproved(): self
    {
        return $this->state(function (): array {
            return [
                'approved_at' => null,
            ];
        });
    }
}
