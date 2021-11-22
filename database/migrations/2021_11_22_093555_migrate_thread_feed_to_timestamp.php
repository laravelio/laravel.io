<?php

use App\Models\Thread;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateThreadFeedToTimestamp extends Migration
{
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->timestamp('last_active_at')
                ->after('slug')
                ->nullable()
                ->index();
        });

        // Iterate over all the threads and update the `last_active_at` timestamp to
        // the latest reply `created_at` or thread `created_at` if no reply exists.
        Thread::with(['repliesRelation' => function ($query) {
            $query->latest();
        }])
            ->lazy()
            ->each(function ($thread) {
                $thread->update([
                    'last_active_at' => ($reply = $thread->replies()->first()) ? $reply->created_at : $thread->created_at,
                ]);
            });
    }
}
