<?php

namespace Tests\Feature;

use App\Http\Livewire\NotificationIndicator;
use App\Models\Reply;
use App\Models\Thread;
use App\Notifications\NewReplyNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Livewire\Livewire;

class NavigationTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_sees_the_correct_number_of_notifications()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
        ]);

        $thread = factory(Thread::class)->create(['author_id' => $userOne->id()]);
        $reply = factory(Reply::class)->create([
            'author_id' => $userTwo->id(),
            'replyable_id' => $thread->id(),
        ]);

        $this->loginAs($userOne);

        Livewire::test(NotificationIndicator::class)
            ->assertSee('hidden');

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

        Livewire::test(NotificationIndicator::class)
            ->assertSee('rounded-full');
    }
}
