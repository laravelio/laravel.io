<?php

use App\Jobs\DeleteUser;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can delete a user with replies', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create(['author_id' => $user->id()]);
    Reply::factory()->create(['replyable_id' => $thread->id()]);
    Reply::factory()->create(['author_id' => $user->id()]);

    $this->loginAsAdmin();
    $this->dispatch(new DeleteUser($user));

    $this->assertDatabaseMissing('users', ['id' => $user->id()]);
    $this->assertDatabaseMissing('threads', ['author_id' => $user->id()]);
    $this->assertDatabaseMissing('replies', ['replyable_id' => $thread->id()]);
    $this->assertDatabaseMissing('replies', ['author_id' => $user->id()]);
});
