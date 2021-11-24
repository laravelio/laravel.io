<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject' => $this->faker->text(20),
            'body' => $this->faker->text,
            'slug' => $this->faker->unique()->slug,
            'author_id' => $attributes['author_id'] ?? User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-6 months'),
        ];
    }

    public function old(): self
    {
        return $this->state(['created_at' => now()->subMonths(7)]);
    }
}
