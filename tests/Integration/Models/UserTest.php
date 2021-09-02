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

    $this->assertInstanceOf(User::class, User::findByUsername('johndoe'));
});

it('can find by email address', function () {
    $this->createUser(['email' => 'john@example.com']);

    $this->assertInstanceOf(User::class, User::findByEmailAddress('john@example.com'));
});

it('can return the amount of solutions that were given', function () {
    $user = User::factory()->create();
    createTwoSolutionReplies($user);

    $this->assertEquals(2, $user->countSolutions());
});

it('can determine if a given user is the logged in user', function () {
    $user = $this->login();

    $this->assertTrue($user->isLoggedInUser());
});

it('can determine if a given user is not the logged in user', function () {
    $user = $this->createUser();
    $this->login([
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);

    $this->assertFalse($user->isLoggedInUser());
});

// Helpers
function createTwoSolutionReplies(User $user)
{
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
    $thread->markSolution($reply);

    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
    $thread->markSolution($reply);
}
