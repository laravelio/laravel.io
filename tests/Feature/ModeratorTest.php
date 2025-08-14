<?php

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

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
