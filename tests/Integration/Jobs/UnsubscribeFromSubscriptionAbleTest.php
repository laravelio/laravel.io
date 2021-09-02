<?php

use App\Jobs\UnsubscribeFromSubscriptionAble;
use App\Models\Subscription;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('can unsubscribe a user from a thread', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->create();
    Subscription::factory()->create(['user_id' => $user->id(), 'subscriptionable_id' => $thread->id()]);

    expect($thread->hasSubscriber($user))->toBeTrue();

    $this->dispatch(new UnsubscribeFromSubscriptionAble($user, $thread));

    expect($thread->hasSubscriber($user))->toBeFalse();
});
