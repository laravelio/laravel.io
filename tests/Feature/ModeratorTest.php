<?php

use App\Models\Thread;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(LazilyRefreshDatabase::class);

test('moderators can edit any thread', function () {
    $thread = Thread::factory()->create();

    $this->loginAsModerator();

    $this->visit('/forum/'.$thread->slug().'/edit')
        ->assertResponseOk();
});

test('moderators can delete any thread', function () {
    $thread = Thread::factory()->create();

    $this->loginAsModerator();

    $this->delete('/forum/'.$thread->slug())
        ->assertRedirectedTo('/forum');
});
