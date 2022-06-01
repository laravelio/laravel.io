<?php

use App\Http\Livewire\Notifications;
use App\Models\Reply;
use App\Models\Thread;
use App\Notifications\NewReplyNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Livewire;
use function Pest\Laravel\post;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('users_can_see_notifications', function () {
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

test('users_can_mark_notifications_as_read', function () {
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

test('a_non_logged_in_user_cannot_access_notifications', function () {
    Livewire::test(Notifications::class)->assertForbidden();
});

test('a_user_cannot_mark_other_users_notifications_as_read', function () {
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

test('a_user_sees_the_correct_number_of_notifications', function () {
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

    Livewire::test(Notifications::class)
        ->assertSee('10');
});

test('users_can_clear_all_notifications', function () {
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

    $this->loginAs($userOne);

    Livewire::test(Notifications::class)
        ->assertSee('Clear All')
        ->assertViewHas('notificationCount', 1);

    post('/notifications/mark-as-read');

    Livewire::test(Notifications::class)
        ->assertDontSee('Clear All')
        ->assertViewHas('notificationCount', 0);
});
