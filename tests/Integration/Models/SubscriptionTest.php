<?php

use App\Models\Subscription;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(LazilyRefreshDatabase::class);

it('can get a subscription by its uuid', function () {
    $uuid = Subscription::factory()->create()->uuid();

    $subscription = Subscription::findByUuidOrFail($uuid);

    expect($subscription->uuid())->toEqual($uuid);
});
