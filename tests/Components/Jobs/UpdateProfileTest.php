<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Jobs\UpdateProfile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_update_a_user_profile()
    {
        $user = (new UpdateProfile($this->createUser(), ['bio' => 'my bio', 'name' => 'John Doe Junior']))->handle();
        $this->assertEquals('my bio', $user->bio());
        $this->assertEquals('John Doe Junior', $user->name());
    }
}
