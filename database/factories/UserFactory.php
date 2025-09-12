<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\NotificationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        static $password;

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => Str::random(10),
            'github_id' => $this->faker->unique()->numberBetween(10000, 99999),
            'github_username' => $this->faker->unique()->userName(),
            'github_has_identicon' => $this->faker->boolean(),
            'twitter' => $this->faker->unique()->userName(),
            'bluesky' => $this->faker->unique()->userName(),
            'website' => 'https://laravel.io',
            'banned_at' => null,
            'banned_reason' => null,
            'type' => User::DEFAULT,
            'bio' => $this->faker->sentence(),
            'email_verified_at' => now()->subDay(),
            'allowed_notifications' => [
                NotificationType::MENTION,
                NotificationType::REPLY,
            ],
        ];
    }

    public function passwordless(): self
    {
        return $this->state(function () {
            return ['password' => ''];
        });
    }

    public function moderator(): self
    {
        return $this->state(function () {
            return ['type' => User::MODERATOR];
        });
    }

    public function verifiedAuthor(): self
    {
        return $this->state(function () {
            return ['author_verified_at' => now()];
        });
    }
}
