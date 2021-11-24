<?php

use App\Models\Thread;
use Illuminate\Database\Migrations\Migration;

class UpdateLastActivityTimestamp extends Migration
{
    public function up()
    {
        // Iterate over all the threads and update the `last_active_at` timestamp to
        // the latest reply `created_at` or thread `created_at` if no reply exists.
        if (! app()->runningUnitTests()) {
            Thread::with(['repliesRelation' => function ($query) {
                $query->latest();
            }])
                ->lazy()
                ->each(function ($thread) {
                    $thread->last_activity_at = ($reply = $thread->replies()->first()) ? $reply->created_at : $thread->created_at;
                    $thread->save();
                });
        }
    }
}
