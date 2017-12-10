<?php

use App\User;
use App\Models\Thread;
use App\Models\Subscription;

$factory->define(Subscription::class, function (Faker\Generator $faker, array $attributes = []) {
    return [
        'user_id' => $attributes['user_id'] ?? factory(User::class)->create()->id(),
        'subscriptionable_id' => $attributes['subscriptionable_id'] ?? factory(Thread::class)->create()->id(),
        'subscriptionable_type' => Thread::TABLE,
    ];
});
