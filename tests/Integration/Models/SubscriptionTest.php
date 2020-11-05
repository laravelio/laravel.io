<?php

namespace Tests\Integration\Models;

use App\Models\Subscription;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_get_a_subscription_by_its_uuid()
    {
        $uuid = Subscription::factory()->create()->uuid();

        $subscription = Subscription::findByUuidOrFail($uuid);

        $this->assertEquals($uuid, $subscription->uuid());
    }
}
