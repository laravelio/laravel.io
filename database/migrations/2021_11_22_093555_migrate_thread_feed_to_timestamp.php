<?php

use App\Models\Thread;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateThreadFeedToTimestamp extends Migration
{
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->timestamp('last_activity_at')
                ->after('slug')
                ->nullable()
                ->index();
        });

        // Iterate over all the threads and update the `last_active_at` timestamp to
        // the latest reply `created_at` or thread `created_at` if no reply exists.
        if (! app()->runningUnitTests()) {
            Thread::with(['repliesRelation' => function ($query) {
                $query->latest();
            }])
                ->lazy()
                ->each(function ($thread) {
                    $thread->update([
                        'last_activity_at' => ($reply = $thread->replies()->first()) ? $reply->created_at : $thread->created_at,
                    ]);
                });
        }
    }
}
