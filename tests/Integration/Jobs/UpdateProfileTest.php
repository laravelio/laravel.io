<?php

namespace Tests\Integration\Jobs;

use App\Events\EmailAddressWasChanged;
use App\Jobs\UpdateProfile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_update_a_user_profile()
    {
        $user = $this->createUser();

        Event::fake();

        $updatedUser = $this->dispatch(new UpdateProfile($user, ['bio' => 'my bio', 'name' => 'John Doe Junior']));

        $this->assertEquals('my bio', $updatedUser->bio());
        $this->assertEquals('John Doe Junior', $updatedUser->name());
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'email_verified_at' => null]);

        Event::assertNotDispatched(EmailAddressWasChanged::class);
    }

    /** @test */
    public function changing_the_email_address_emits_an_event()
    {
        $user = $this->createUser();

        Event::fake();

        $this->dispatch(new UpdateProfile($user, ['email' => 'foo@example.com']));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email_verified_at' => null]);

        Event::assertDispatched(EmailAddressWasChanged::class, function (EmailAddressWasChanged $event) {
            return $event->user->email === 'foo@example.com';
        });
    }
}
