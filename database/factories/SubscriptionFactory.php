<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'user_id' => $attributes['user_id'] ?? User::factory()->create()->id(),
            'subscriptionable_id' => $attributes['subscriptionable_id'] ?? Thread::factory()->create()->id(),
            'subscriptionable_type' => Thread::TABLE,
        ];
    }
}
