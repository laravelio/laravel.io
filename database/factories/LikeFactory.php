<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }

    public function reply(): self
    {
        return $this->state(function () {
            return [
                'likeable_id' => function () {
                    return Reply::factory()->create()->id;
                },
                'likeable_type' => 'replies',
            ];
        });
    }

    public function thread(): self
    {
        return $this->state(function () {
            return [
                'likeable_id' => function () {
                    return Thread::factory()->create()->id;
                },
                'likeable_type' => 'threads',
            ];
        });
    }
}
