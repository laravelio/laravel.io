<?php

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseTransactions::class);

test('moderators can edit any thread', function () {
    $thread = Thread::factory()->create();

    $this->loginAsModerator();

    $this->get('/forum/'.$thread->slug().'/edit')
        ->assertSuccessful();
});

test('moderators can delete any thread', function () {
    $thread = Thread::factory()->create();

    $this->loginAsModerator();

    $this->delete('/forum/'.$thread->slug())
        ->assertRedirect('/forum');
});
