<?php

namespace Tests\Components\Jobs;

use App\Jobs\ConfirmUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ConfirmUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_confirm_a_user()
    {
        $user = $this->createUser(['confirmed' => false]);

        $confirmedUser = $this->dispatch(new ConfirmUser($user));

        $this->assertTrue($confirmedUser->isConfirmed());
    }
}
