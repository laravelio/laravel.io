<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReplySeeder extends Seeder
{
    public function run()
    {
        $userIds = array_flip(DB::table('users')->pluck('id')->toArray());
        $threads = Thread::all();

        DB::beginTransaction();

        // Create 5 replies for each thread from random users.
        foreach ($threads as $thread) {
            Reply::factory()
                ->count(5)
                ->state(new Sequence(
                    fn () => [
                        'author_id' => array_rand($userIds),
                        'replyable_id' => $thread->id,
                    ],
                ))
                ->createQuietly();
        }

        DB::commit();

        DB::beginTransaction();

        // Give 10 random threads a solution.
        foreach ($threads->random(20) as $thread) {
            $thread->markSolution($thread->repliesRelation()->get()->load('replyAbleRelation')->random(), $thread->author());
        }

        DB::commit();
    }
}
