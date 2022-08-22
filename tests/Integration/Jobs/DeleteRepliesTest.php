<?php

use App\Jobs\DeleteReply;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('reply authors can force delete their replies', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['author_id' => $user->id(), 'replyable_id' => $thread->id()]);

    $this->loginAs($user);
    $this->dispatch(new DeleteReply($reply));

    $this->assertDatabaseMissing('replies', ['id' => $reply->id()]);
});

test('admins can soft delete replies', function () {
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);
    $reason = 'Reason';

    $this->loginAsAdmin();
    $this->dispatch(new DeleteReply($reply, $reason));

    $this->assertSoftDeleted('replies', ['id' => $reply->id()]);

    expect($reply->isDeletedBy(auth()->user()))->toBeTrue();
    expect($reply->deleted_at)->not()->toBeNull();
    expect($reply->deleted_reason)->not()->toBeNull();
    expect($reply->deleted_reason)->toBe($reason);
});
