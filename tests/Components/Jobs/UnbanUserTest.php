<?php

namespace Tests\Components\Jobs;

use Carbon\Carbon;
use Tests\TestCase;
use App\Jobs\UnbanUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UnbanUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_unban_a_user()
    {
        $user = $this->createUser(['banned_at' => Carbon::yesterday()]);

        $unbannedUser = $this->dispatch(new UnbanUser($user));

        $this->assertFalse($unbannedUser->isBanned());
    }
}
