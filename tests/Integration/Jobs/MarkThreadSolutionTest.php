<?php

use App\Jobs\MarkThreadSolution;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can mark thread solution', function () {
    $user = $this->login();
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create();

    $this->dispatch(new MarkThreadSolution($thread, $reply, $user));

    expect($thread->isSolutionReply($reply))->toBeTrue();
    expect($thread->wasResolvedBy($user))->toBeTrue();
});
