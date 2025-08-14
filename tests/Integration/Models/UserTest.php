<?php

use App\Jobs\MarkThreadSolution;
use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

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

it('only returns approved articles for a user', function () {
    $user = $this->createUser();

    Article::factory()->approved()->create(['author_id' => $user->id]);
    Article::factory()->unapproved()->create(['author_id' => $user->id]);

    expect($user->latestArticles())->toHaveCount(1);
    expect($user->countArticles())->toBe(1);
});

it('excludes author solutions from mostSolutions count', function () {
    $user = $this->login();
    $thread = Thread::factory()->create([
        'author_id' => $user->id(),
    ]);
    $reply = Reply::factory()->create([
        'author_id' => $user->id(),
    ]);

    $this->dispatch(new MarkThreadSolution($thread, $reply, $user));

    expect($user->mostSolutions()->find($user->id()))->toBeNull();

    $otherThread = Thread::factory()->create();

    $this->dispatch(new MarkThreadSolution($otherThread, $reply, $user));

    expect($user->mostSolutions()->find($user->id())->solutions_count)->toBe(1);
})->group('emeka');

it('only shows users with solutions in the widget', function () {
    $userWithSolution = User::factory()->create();
    $userWithoutSolution = User::factory()->create();
    $anotherUserWithSolution = User::factory()->create();

    $thread1 = Thread::factory()->create();
    $thread2 = Thread::factory()->create();

    $reply1 = Reply::factory()->create([
        'author_id' => $userWithSolution->id,
    ]);

    $reply2 = Reply::factory()->create([
        'author_id' => $anotherUserWithSolution->id,
    ]);

    $this->dispatch(new MarkThreadSolution($thread1, $reply1, $userWithSolution));
    $this->dispatch(new MarkThreadSolution($thread2, $reply2, $anotherUserWithSolution));

    $topMembers = User::mostSolutions(365)->take(5)->get();

    expect($topMembers)->toHaveCount(2)
        ->and($topMembers->pluck('id'))->toContain($userWithSolution->id)
        ->and($topMembers->pluck('id'))->toContain($anotherUserWithSolution->id)
        ->and($topMembers->pluck('id'))->not->toContain($userWithoutSolution->id);
})->group('widget');

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
