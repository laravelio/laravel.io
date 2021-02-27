<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $password;

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => Str::random(10),
            'github_id' => $this->faker->numberBetween(10000, 99999),
            'github_username' => $this->faker->unique()->userName,
            'twitter' => $this->faker->unique()->userName,
            'banned_at' => null,
            'type' => User::DEFAULT,
            'bio' => $this->faker->sentence,
            'email_verified_at' => now()->subDay(),
        ];
    }

    public function passwordless()
    {
        return $this->state(function () {
            return [
                'password' => '',
            ];
        });
    }
}
