<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        static $password;

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => Str::random(10),
            'github_id' => $this->faker->unique()->numberBetween(10000, 99999),
            'github_username' => $this->faker->unique()->userName,
            'twitter' => $this->faker->unique()->userName,
            'banned_at' => null,
            'type' => User::DEFAULT,
            'bio' => $this->faker->sentence,
            'email_verified_at' => now()->subDay(),
        ];
    }

    public function passwordless(): self
    {
        return $this->state(function () {
            return [
                'password' => '',
            ];
        });
    }
}
