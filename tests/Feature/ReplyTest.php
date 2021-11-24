<?php

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('users can add a reply to a thread', function () {
    $thread = Thread::factory()->create(['subject' => 'The first thread', 'slug' => 'the-first-thread']);

    $this->login();

    $this->post('/replies', [
        'body' => 'The first reply',
        'replyable_id' => $thread->id,
        'replyable_type' => Thread::TABLE,
    ])
        ->assertSessionHas('success', 'Reply successfully added!');
});

test('users can edit a reply', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->create(['slug' => 'the-first-thread']);
    Reply::factory()->create(['author_id' => $user->id(), 'replyable_id' => $thread->id()]);

    $this->loginAs($user);

    $this->put('/replies/1', [
        'body' => 'The updated reply',
    ])
        ->assertRedirectedTo('/forum/the-first-thread')
        ->assertSessionHas('success', 'Reply successfully updated!');
});

test('users cannot edit a reply they do not own', function () {
    Reply::factory()->create();

    $this->login();

    $this->get('/replies/1/edit')
        ->assertForbidden();
});

test('users cannot delete a reply they do not own', function () {
    Reply::factory()->create();

    $this->login();

    $this->delete('/replies/1')
        ->assertForbidden();
});

test('users cannot mark a reply as the solution of the thread if they do not own the thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create(['author_id' => $user->id(), 'slug' => 'the-first-thread']);
    $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);

    $this->login();

    $this->put('/forum/the-first-thread/mark-solution/'.$reply->id())
        ->assertForbidden();
});

test('users cannot reply to a thread if the last reply is older than six months', function () {
    $thread = Thread::factory()->old()->create();

    $this->login();

    $this->visit("/forum/{$thread->slug}")
        ->dontSee('value="Reply"')
        ->seeText(
            'The last reply to this thread was more than six months ago. Please consider opening a new thread if you have a similar question.',
        );
});

test('verified users can see the reply input', function () {
    $thread = Thread::factory()->create();

    $this->login();

    $this->visit("/forum/{$thread->slug}")
        ->see('name="body"');
});

test('unverified users cannot see the reply input', function () {
    $thread = Thread::factory()->create();

    $this->login(['email_verified_at' => null]);

    $this->visit("/forum/{$thread->slug}")
        ->dontSee('name="body"')
        ->seeText(
            'You\'ll need to verify your account before participating in this thread.',
        );
});

test('replyable activity is updated when reply is created', function () {
    $thread = Thread::factory()->create(['subject' => 'The first thread', 'slug' => 'the-first-thread']);

    $this->login();

    $this->post('/replies', [
        'body' => 'The first reply',
        'replyable_id' => $thread->id,
        'replyable_type' => Thread::TABLE,
    ]);

    $this->assertNotNull($thread->fresh()->last_activity_at);
});
