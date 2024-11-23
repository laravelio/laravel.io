<?php

use App\Jobs\DeleteUserThreads;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can delete an user threads', function () {
    $user = User::factory()->create();

    Thread::factory()->for($user, 'authorRelation')->count(5)->create();

    $this->loginAsAdmin();
    $this->dispatch(new DeleteUserThreads($user));

    $this->assertDatabaseMissing('threads', ['author_id' => $user->id()]);
});
