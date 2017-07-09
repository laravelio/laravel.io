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
        $user = $this->login(['name' => 'John Doe', 'email' => 'john@example.com', 'username' => 'johndoe']);

        (new UpdateProfile($user, ['bio' => 'my bio', 'name' => 'John Doe Junior']))->handle();

        $this->assertEquals('my bio', $user->bio());
        $this->assertEquals('John Doe Junior', $user->name());
    }
}
