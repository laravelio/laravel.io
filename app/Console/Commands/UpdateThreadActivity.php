<?php

namespace App\Console\Commands;

use App\Models\Thread;
use Illuminate\Console\Command;

class UpdateThreadActivity extends Command
{
    protected $signature = 'update-thread-activity';

    protected $description = 'Upate the last_activity timestamp of all threads';

    public function handle()
    {
        // Iterate over all the threads and update the `last_active_at` timestamp to
        // the latest reply `created_at` or thread `created_at` if no reply exists.
        Thread::with(['repliesRelation' => function ($query) {
            $query->latest();
        }])
            ->lazy()
            ->each(function ($thread) {
                $thread->last_activity_at = ($reply = $thread->replies()->first()) ? $reply->created_at : $thread->created_at;
                $thread->save();
            });

        return Command::SUCCESS;
    }
}
