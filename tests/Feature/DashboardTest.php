<?php

use App\Http\Livewire\NotificationCount;
use App\Http\Livewire\Notifications;
use App\Models\Reply;
use App\Models\Thread;
use App\Notifications\NewReplyNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('requires login', function () {
    $this->visit('/dashboard')
        ->seePageIs('/login');
});

test('users can see some statistics', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->count(3)->create(['author_id' => $user->id()])->first();
    $reply = Reply::factory()->count(2)->create([
        'author_id' => $user->id(),
        'replyable_id' => $thread->id(),
    ])->first();

    $thread->markSolution($reply, $user);

    $this->loginAs($user);

    $this->visit('/dashboard')
        ->see('3 threads')
        ->see('2 replies')
        ->see('1 solution');
});

test('users can see notifications', function () {
    $userOne = $this->createUser();

    $thread = Thread::factory()->create(['author_id' => $userOne->id()]);
    $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);

    $userOne->notifications()->create([
        'id' => Str::random(),
        'type' => NewReplyNotification::class,
        'data' => [
            'type' => 'new_reply',
            'reply' => $reply->id(),
            'replyable_id' => $reply->replyable_id,
            'replyable_type' => $reply->replyable_type,
            'replyable_subject' => $reply->replyAble()->replyAbleSubject(),
        ],
    ]);

    $replyAbleRoute = route('replyable', [$reply->replyable_id, $reply->replyable_type]);

    $this->loginAs($userOne);

    Livewire::test(Notifications::class)
        ->assertSee(new HtmlString(
            "A new reply was added to <a href=\"{$replyAbleRoute}\" class=\"text-lio-700\">\"{$thread->subject()}\"</a>.",
        ));
});

test('users can mark notifications as read', function () {
    $userOne = $this->createUser();

    $thread = Thread::factory()->create(['author_id' => $userOne->id()]);
    $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);

    $notification = $userOne->notifications()->create([
        'id' => Str::random(),
        'type' => NewReplyNotification::class,
        'data' => [
            'type' => 'new_reply',
            'reply' => $reply->id(),
            'replyable_id' => $reply->replyable_id,
            'replyable_type' => $reply->replyable_type,
            'replyable_subject' => $reply->replyAble()->replyAbleSubject(),
        ],
    ]);

    $replyAbleRoute = route('replyable', [$reply->replyable_id, $reply->replyable_type]);

    $this->loginAs($userOne);

    Livewire::test(Notifications::class)
        ->assertSee(new HtmlString(
            "A new reply was added to <a href=\"{$replyAbleRoute}\" class=\"text-lio-700\">\"{$thread->subject()}\"</a>.",
        ))
        ->call('markAsRead', $notification->id)
        ->assertDontSee(new HtmlString(
            "A new reply was added to <a href=\"{$replyAbleRoute}\" class=\"text-lio-700\">\"{$thread->subject()}\"</a>.",
        ))
        ->assertEmitted('NotificationMarkedAsRead');
});

test('a non logged in user cannot access notifications', function () {
    Livewire::test(Notifications::class)
        ->assertForbidden();
});

test('a user cannot mark other users notifications as read', function () {
    $userOne = $this->createUser();
    $userTwo = $this->createUser([
        'name' => 'Jane Doe',
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);

    $thread = Thread::factory()->create(['author_id' => $userOne->id()]);
    $reply = Reply::factory()->create([
        'author_id' => $userTwo->id(),
        'replyable_id' => $thread->id(),
    ]);

    $notification = $userOne->notifications()->create([
        'id' => Str::random(),
        'type' => NewReplyNotification::class,
        'data' => [
            'type' => 'new_reply',
            'reply' => $reply->id(),
            'replyable_id' => $reply->replyable_id,
            'replyable_type' => $reply->replyable_type,
            'replyable_subject' => $reply->replyAble()->replyAbleSubject(),
        ],
    ]);

    $this->loginAs($userTwo);

    Livewire::test(Notifications::class)
        ->call('markAsRead', $notification->id)
        ->assertForbidden();
});

test('a user sees the correct number of notifications', function () {
    $userOne = $this->createUser();
    $userTwo = $this->createUser([
        'name' => 'Jane Doe',
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);

    $thread = Thread::factory()->create(['author_id' => $userOne->id()]);
    $reply = Reply::factory()->create([
        'author_id' => $userTwo->id(),
        'replyable_id' => $thread->id(),
    ]);

    for ($i = 0; $i < 10; $i++) {
        $userOne->notifications()->create([
            'id' => Str::random(),
            'type' => NewReplyNotification::class,
            'data' => [
                'type' => 'new_reply',
                'reply' => $reply->id(),
                'replyable_id' => $reply->replyable_id,
                'replyable_type' => $reply->replyable_type,
                'replyable_subject' => $reply->replyAble()->replyAbleSubject(),
            ],
        ]);
    }

    $this->loginAs($userOne);

    Livewire::test(NotificationCount::class)
        ->assertSee('10');
});
