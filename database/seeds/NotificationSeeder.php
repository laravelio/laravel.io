<?php

use App\Models\Reply;
use App\Notifications\NewReplyNotification;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

class NotificationSeeder extends Seeder
{
    use WithFaker;

    public function run()
    {
        Reply::all()->each(function (Reply $reply) {
            DatabaseNotification::create([
                'id' => Uuid::uuid4()->toString(),
                'type' => NewReplyNotification::class,
                'notifiable_id' => $reply->author_id,
                'notifiable_type' => User::TABLE,
                'data' => [
                    'type' => 'new_reply',
                    'reply' => $reply->id(),
                    'replyable_id' => $reply->replyable_id,
                    'replyable_type' => $reply->replyable_type,
                    'replyable_subject' => $reply->replyAble()->replyAbleSubject(),
                ],
                'created_at' => $reply->createdAt(),
                'updated_at' => $reply->createdAt(),
            ]);
        });
    }
}
