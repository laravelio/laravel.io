<?php

use App\Http\Livewire\NotificationIndicator;
use App\Models\Reply;
use App\Models\Thread;
use App\Notifications\NewReplyNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

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
});
