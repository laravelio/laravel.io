<?php

use App\Jobs\SubscribeToSubscriptionAble;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('can subscribe a user to a thread', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->create();

    expect($thread->hasSubscriber($user))->toBeFalse();

    $this->dispatch(new SubscribeToSubscriptionAble($user, $thread));

    expect($thread->hasSubscriber($user))->toBeTrue();
});
