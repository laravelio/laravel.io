<?php

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('can find by username', function () {
    $this->createUser(['username' => 'johndoe']);

    expect(User::findByUsername('johndoe'))->toBeInstanceOf(User::class);
});

it('can find by email address', function () {
    $this->createUser(['email' => 'john@example.com']);

    expect(User::findByEmailAddress('john@example.com'))->toBeInstanceOf(User::class);
});

it('can return the amount of solutions that were given', function () {
    $user = User::factory()->create();
    createTwoSolutionReplies($user);

    expect($user->countSolutions())->toEqual(2);
});

it('can determine if a given user is the logged in user', function () {
    $user = $this->login();

    expect($user->isLoggedInUser())->toBeTrue();
});

it('can determine if a given user is not the logged in user', function () {
    $user = $this->createUser();
    $this->login([
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);

    expect($user->isLoggedInUser())->toBeFalse();
});

// Helpers
function createTwoSolutionReplies(User $user)
{
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
    $thread->markSolution($reply, $user);

    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
    $thread->markSolution($reply, $user);
}
