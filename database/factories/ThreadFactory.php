<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject' => $this->faker->text(20),
            'body' => $this->faker->text,
            'slug' => $this->faker->unique()->slug,
            'author_id' => $attributes['author_id'] ?? User::factory()->create()->id(),
        ];
    }

    public function old()
    {
        return $this->state(['created_at' => now()->subMonths(7)]);
    }
}
