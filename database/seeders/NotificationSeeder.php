<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Notifications\NewReplyNotification;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class NotificationSeeder extends Seeder
{
    use WithFaker;

    public function run()
    {
        $replies = Reply::with(['authorRelation.notifications', 'replyAbleRelation'])->get();

        DB::beginTransaction();

        foreach ($replies as $reply) {
            $reply->author()->notifications()->create([
                'id' => Uuid::uuid4()->toString(),
                'type' => NewReplyNotification::class,
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
        }

        DB::commit();
    }
}
