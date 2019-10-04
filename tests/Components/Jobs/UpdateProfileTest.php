<?php

namespace Tests\Components\Jobs;

use App\Jobs\UpdateProfile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_update_a_user_profile()
    {
        $user = $this->createUser();

        $updatedUser = $this->dispatch(new UpdateProfile($user, ['bio' => 'my bio', 'name' => 'John Doe Junior']));

        $this->assertEquals('my bio', $updatedUser->bio());
        $this->assertEquals('John Doe Junior', $updatedUser->name());
    }
}
