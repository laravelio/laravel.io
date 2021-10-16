<?php

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('pages without a canonical url explicitly set fall back to the current url', function () {
    $this->get('/register')
        ->see('<link rel="canonical" href="http://localhost/register" />');
});

test('pages with a canonical url are rendered correctly', function () {
    $thread = Thread::factory()->create(['subject' => 'The first thread']);

    $this->get("forum/{$thread->slug()}")
        ->see('<link rel="canonical" href="http://localhost/forum/'.$thread->slug().'" />');
});

test('first page of paginated list removes page=1 from canonical url', function () {
    $this->get('forum?page=1')
        ->see('<link rel="canonical" href="http://localhost/forum" />');
});

test('subsequent pages of paginated list sets the full url as canonical', function () {
    $this->get('forum?page=2')
        ->see('<link rel="canonical" href="http://localhost/forum?page=2" />');
});
