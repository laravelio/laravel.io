<?php

namespace Tests\Feature;

use App\Http\Livewire\NotificationCount;
use Illuminate\Support\Str;
use App\Http\Livewire\Notifications;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Arr;
use Livewire\Livewire;

class DashboardTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function requires_login()
    {
        $this->visit('/dashboard')
            ->seePageIs('/login');
    }

    /** @test */
    public function users_can_see_some_statistics()
    {
        $user = $this->createUser();
        $thread = Arr::first(factory(Thread::class, 3)->create(['author_id' => $user->id()]));
        $reply = Arr::first(factory(Reply::class, 2)->create([
            'author_id' => $user->id(),
            'replyable_id' => $thread->id(),
        ]));
        $thread->markSolution($reply);

        $this->loginAs($user);

        $this->visit('/dashboard')
            ->see('3 threads')
            ->see('2 replies')
            ->see('1 solution');
    }

    /** @test */
    public function users_can_see_notifications()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser(['name' => 'Jane Doe', 'username' => 'janedoe', 'email' => 'jane@example.com']);

        $thread = factory(Thread::class)->create(['author_id' => $userOne->id()]);
        $reply = factory(Reply::class)->create([
            'author_id' => $userTwo->id(),
            'replyable_id' => $thread->id(),
        ]);

        $userOne->notifications()->create([
            'id' => Str::random(),
            'type' => "App\\Notifications\\NewReplyNotification",
            'data' => [
                'type' => 'reply',
                'author' => $reply->author(),
                'reply' => $reply,
                'thread' => $reply->replyAble(),
            ]
        ]);

        $profileRoute = route('profile', $userTwo->username());
        $threadRoute = route('thread', $thread->slug());

        $this->loginAs($userOne);

        Livewire::test(Notifications::class)
            ->assertSee("<a href=\"{$profileRoute}\" class=\"text-green-darker\">Jane Doe</a> replied to your <a href=\"{$threadRoute}\" class=\"text-green-darker\">thread</a>");
    }

    /** @test */
    public function users_can_mark_notifications_as_read()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser(['name' => 'Jane Doe', 'username' => 'janedoe', 'email' => 'jane@example.com']);

        $thread = factory(Thread::class)->create(['author_id' => $userOne->id()]);
        $reply = factory(Reply::class)->create([
            'author_id' => $userTwo->id(),
            'replyable_id' => $thread->id(),
        ]);

        $notification = $userOne->notifications()->create([
            'id' => Str::random(),
            'type' => "App\\Notifications\\NewReplyNotification",
            'data' => [
                'type' => 'reply',
                'author' => $reply->author(),
                'reply' => $reply,
                'thread' => $reply->replyAble(),
            ]
        ]);

        $profileRoute = route('profile', $userTwo->username());
        $threadRoute = route('thread', $thread->slug());

        $this->loginAs($userOne);

        Livewire::test(Notifications::class)
            ->assertSee("<a href=\"{$profileRoute}\" class=\"text-green-darker\">Jane Doe</a> replied to your <a href=\"{$threadRoute}\" class=\"text-green-darker\">thread</a>")
            ->call('markAsRead', $notification->id)
            ->assertDontSee("<a href=\"{$profileRoute}\" class=\"text-green-darker\">Jane Doe</a> replied to your <a href=\"{$threadRoute}\" class=\"text-green-darker\">thread</a>")
            ->assertEmitted('notificationMarkedAsRead');
    }

    /** @test */
    public function a_non_logged_in_user_cannot_access_notifications()
    {
        Livewire::test(Notifications::class)
            ->assertForbidden();
    }

    /** @test */
    public function a_user_cannot_mark_other_users_notifications_as_read()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser(['name' => 'Jane Doe', 'username' => 'janedoe', 'email' => 'jane@example.com']);

        $thread = factory(Thread::class)->create(['author_id' => $userOne->id()]);
        $reply = factory(Reply::class)->create([
            'author_id' => $userTwo->id(),
            'replyable_id' => $thread->id(),
        ]);

        $notification = $userOne->notifications()->create([
            'id' => Str::random(),
            'type' => "App\\Notifications\\NewReplyNotification",
            'data' => [
                'type' => 'reply',
                'author' => $reply->author(),
                'reply' => $reply,
                'thread' => $reply->replyAble(),
            ]
        ]);

        $this->loginAs($userTwo);

        $this->expectException(AuthorizationException::class);

        Livewire::test(Notifications::class)
            ->call('markAsRead', $notification->id);
    }

    /** @test */
    public function a_user_sees_the_correct_number_of_notifications()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser(['name' => 'Jane Doe', 'username' => 'janedoe', 'email' => 'jane@example.com']);

        $thread = factory(Thread::class)->create(['author_id' => $userOne->id()]);
        $reply = factory(Reply::class)->create([
            'author_id' => $userTwo->id(),
            'replyable_id' => $thread->id(),
        ]);

        for ($i = 0; $i < 10; $i++) {
            $userOne->notifications()->create([
                'id' => Str::random(),
                'type' => "App\\Notifications\\NewReplyNotification",
                'data' => [
                    'type' => 'reply',
                    'author' => $reply->author(),
                    'reply' => $reply,
                    'thread' => $reply->replyAble(),
                ]
            ]);
        }

        $this->loginAs($userOne);

        Livewire::test(NotificationCount::class, 100)
            ->assertSee('10');

        Livewire::test(NotificationCount::class, 9)
            ->assertSee('9+');
    }
}
