<?php

namespace Tests\Components\Jobs;

use App\Jobs\BanUser;
use App\Jobs\UnbanUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UnbanUserTest extends JobTestCase
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
