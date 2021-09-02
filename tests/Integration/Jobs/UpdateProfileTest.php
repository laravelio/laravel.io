<?php

use App\Events\EmailAddressWasChanged;
use App\Jobs\UpdateProfile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can update a user profile', function () {
    $user = $this->createUser();

    Event::fake();

    $updatedUser = $this->dispatch(new UpdateProfile($user, ['bio' => 'my bio', 'name' => 'John Doe Junior']));

    expect($updatedUser->bio())->toEqual('my bio');
    expect($updatedUser->name())->toEqual('John Doe Junior');
    $this->assertDatabaseMissing('users', ['id' => $user->id, 'email_verified_at' => null]);

    Event::assertNotDispatched(EmailAddressWasChanged::class);
});

test('changing the email address emits an event', function () {
    $user = $this->createUser();

    Event::fake();

    $this->dispatch(new UpdateProfile($user, ['email' => 'foo@example.com']));

    $this->assertDatabaseHas('users', ['id' => $user->id, 'email_verified_at' => null]);

    Event::assertDispatched(EmailAddressWasChanged::class, function (EmailAddressWasChanged $event) {
        return $event->user->email === 'foo@example.com';
    });
});
