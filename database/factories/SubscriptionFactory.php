<?php

use App\Models\Subscription;
use App\Models\Thread;
use App\User;
use Ramsey\Uuid\Uuid;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Subscription::class, function (Faker\Generator $faker, array $attributes = []) {
    return [
        'uuid' => Uuid::uuid4()->toString(),
        'user_id' => $attributes['user_id'] ?? factory(User::class)->create()->id(),
        'subscriptionable_id' => $attributes['subscriptionable_id'] ?? factory(Thread::class)->create()->id(),
        'subscriptionable_type' => Thread::TABLE,
    ];
});
