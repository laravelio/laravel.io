<?php

use App\Jobs\DeleteReply;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can delete a thread replies', function () {
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);

    $this->login();
    $this->dispatch(new DeleteReply($reply));

    $this->assertSoftDeleted('replies', ['replyable_type' => 'threads', 'replyable_id' => $thread->id()]);

    expect($reply->isDeletedBy(auth()->user()))->toBeTrue();
    expect($reply->deleted_at)->not()->toBeNull();
});
