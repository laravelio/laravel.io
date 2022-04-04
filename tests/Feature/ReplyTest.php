<?php

use App\Http\Livewire\EditReply;
use App\Mail\MentionEmail;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\MentionNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
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

test('edit reply component is present on the page', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->create(['slug' => 'the-first-thread']);
    Reply::factory()->create(['author_id' => $user->id(), 'replyable_id' => $thread->id()]);

    $this->loginAs($user);

    $this->visit("/forum/{$thread->slug()}")
        ->see('Update reply');
});

test('edit reply component is not present on the page when not owned by user', function () {
    $thread = Thread::factory()->create(['slug' => 'the-first-thread']);
    Reply::factory()->create(['replyable_id' => $thread->id()]);

    $this->login();

    $this->visit("/forum/{$thread->slug()}")
        ->dontSee('Update reply');
});

test('users can edit a reply', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->create(['slug' => 'the-first-thread']);
    $reply = Reply::factory()->create(['author_id' => $user->id(), 'replyable_id' => $thread->id()]);

    $this->actingAs($user);

    Livewire::test(EditReply::class, ['reply' => $reply])
        ->call('updateReply', 'Hope this helps!');

    $this->assertSame('Hope this helps!', $reply->fresh()->body());
});

test('users cannot edit a reply they do not own', function () {
    $reply = Reply::factory()->create();

    $this->login();

    Livewire::test(EditReply::class, ['reply' => $reply])
        ->call('updateReply', 'Hope this helps!')
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

test('users cannot see the option to reply if the latest activity is older than six months', function () {
    $thread = Thread::factory()->old()->create();

    $this->login();

    $this->visit("/forum/{$thread->slug}")
        ->dontSee('value="Reply"')
        ->seeText(
            'The last reply to this thread was more than six months ago. Please consider opening a new thread if you have a similar question.',
        );
});

test('users cannot reply to a thread if the latest activity is older than six months', function () {
    $thread = Thread::factory()->old()->create();

    $this->login();

    $this->post('/replies', [
        'body' => 'The first reply',
        'replyable_id' => $thread->id,
        'replyable_type' => Thread::TABLE,
    ])->assertForbidden();
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

test('replyable updated_at timestamp is not touched when reply is created', function () {
    $thread = Thread::factory()->create(['subject' => 'The first thread', 'slug' => 'the-first-thread', 'updated_at' => '1970-01-01']);

    $this->login();

    $this->post('/replies', [
        'body' => 'The first reply',
        'replyable_id' => $thread->id,
        'replyable_type' => Thread::TABLE,
    ]);

    $this->assertSame('1970-01-01', $thread->fresh()->updated_at->format('Y-m-d'));
});

test('users are notified by email when mentioned in a reply body', function () {
    Notification::fake();
    $user = User::factory()->create(['username' => 'janedoe']);
    $thread = Thread::factory()->create(['subject' => 'The first thread', 'slug' => 'the-first-thread']);

    $this->login();

    $this->post('/replies', [
        'body' => 'Hey @janedoe',
        'replyable_id' => $thread->id,
        'replyable_type' => Thread::TABLE,
    ]);

    Notification::assertSentTo($user, MentionNotification::class, function ($notification) use ($user) {
        return $notification->toMail($user) instanceof MentionEmail;
    });
});

test('users provided with a UI notification when mentioned in a reply body', function () {
    $user = User::factory()->create(['username' => 'janedoe']);
    $thread = Thread::factory()->create(['subject' => 'The first thread', 'slug' => 'the-first-thread']);

    $this->login();

    $this->post('/replies', [
        'body' => 'Hey @janedoe',
        'replyable_id' => $thread->id,
        'replyable_type' => Thread::TABLE,
    ]);

    $notification = DatabaseNotification::first();
    $this->assertSame($user->id, (int) $notification->notifiable_id);
    $this->assertSame('users', $notification->notifiable_type);
    $this->assertSame('mention', $notification->data['type']);
    $this->assertSame('The first thread', $notification->data['replyable_subject']);
});

test('users are not notified when mentioned in an edited reply', function () {
    Notification::fake();

    $user = $this->createUser();
    $thread = Thread::factory()->create(['slug' => 'the-first-thread']);
    Reply::factory()->create(['author_id' => $user->id(), 'replyable_id' => $thread->id()]);

    $this->loginAs($user);

    $this->put('/replies/1', [
        'body' => 'The updated reply',
    ]);

    Notification::assertNothingSent();
});
