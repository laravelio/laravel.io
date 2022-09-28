<?php

use App\Jobs\ReportSpam;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\MarkedAsSpamNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('can mark a thread as spam', function () {
    $user = $this->login();
    $thread = Thread::factory()->create();

    $this->dispatch(new ReportSpam($user, $thread));

    $thread->refresh();

    expect($thread->spamReportersRelation()->count())->toBe(1);
    expect($thread->spamReporters()->contains($user))->toBeTrue();
});

it('can mark a reply as spam', function () {
    $user = $this->login();
    $reply = Reply::factory()->create();

    $this->dispatch(new ReportSpam($user, $reply));

    $reply->refresh();

    expect($reply->spamReportersRelation()->count())->toBe(1);
    expect($reply->spamReporters()->contains($user))->toBeTrue();
});

it('can notify moderators if a thread is marked three times', function () {
    Notification::fake();

    $thread = Thread::factory()->create();
    $users = User::factory(7)->create();
    User::factory()->create(['type' => User::MODERATOR]);

    $users->each(function ($user, $index) use ($thread) {
        $this->dispatch(new ReportSpam($user, $thread));
    });

    Notification::assertSentOnDemandTimes(MarkedAsSpamNotification::class, 2);
});
