<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class SubscriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'user_id' => $attributes['user_id'] ?? User::factory()->create()->id(),
            'subscriptionable_id' => $attributes['subscriptionable_id'] ?? Thread::factory()->create()->id(),
            'subscriptionable_type' => Thread::TABLE,
        ];
    }
}
