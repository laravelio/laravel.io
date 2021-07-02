<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $threads = Thread::all();

        // Create 5 replies for each thread from random users.
        $threads->each(function ($thread) use ($users) {
            Reply::factory()
                ->count(5)
                ->state(new Sequence(
                    fn () => [
                        'author_id' => $users->random()->id,
                        'replyable_id' => $thread->id,
                    ],
                ))
                ->create();
        });

        // Give 10 random threads a solution.
        $threads->random(20)->each(function ($thread) {
            $thread->markSolution($thread->repliesRelation()->get()->random());
        });
    }
}
