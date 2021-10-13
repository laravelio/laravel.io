<?php

use App\Jobs\UnmarkThreadSolution;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can unmark thread solution', function () {
    $user = $this->login();
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create();

    $thread->markSolution($reply, $user);
    expect($thread->isSolutionReply($reply))->toBeTrue();
    expect($thread->wasResolvedBy($user))->toBeTrue();

    $this->dispatch(new UnmarkThreadSolution($thread));

    expect($thread->isSolutionReply($reply))->toBeFalse();
    expect($thread->fresh()->wasResolvedBy($user))->toBeFalse();
});
