<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexes extends Migration
{
    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->index('author_id');
            $table->index('most_recent_reply_id');
            $table->index('solution_reply_id');
        });

        Schema::table('forum_replies', function (Blueprint $table) {
            $table->index('author_id');
            $table->index('thread_id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index('author_id');
        });
    }
}
