<?php

use App\Jobs\MarkThreadAsSpam;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadMarkedAsSpamNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('can mark thread solution', function () {
    $user = $this->login();
    $thread = Thread::factory()->create();

    $this->dispatch(new MarkThreadAsSpam($user, $thread));

    $thread->refresh();

    expect($thread->usersMarkingAsSpam()->count())->toBe(1);
    expect($thread->usersMarkingAsSpam->contains($user))->toBeTrue();
});

it('can notify moderators if a thread is marked three times', function () {
    Notification::fake();
    $thread = Thread::factory()->create();
    $users = User::factory(3)->create();
    $moderator = User::factory()->create(['type' => User::MODERATOR]);

    $users->each(function ($user, $index) use ($thread, $moderator) {
        $this->dispatch(new MarkThreadAsSpam($user, $thread));
        match ($index) {
            2 => Notification::assertSentTo($moderator, ThreadMarkedAsSpamNotification::class),
            default => Notification::assertNotSentTo($moderator, ThreadMarkedAsSpamNotification::class),
        };
    });
});
