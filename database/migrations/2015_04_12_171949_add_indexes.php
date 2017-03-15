<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropIndex(['author_id']);
            $table->dropIndex(['most_recent_reply_id']);
            $table->dropIndex(['solution_reply_id']);
        });

        Schema::table('forum_replies', function (Blueprint $table) {
            $table->dropIndex(['author_id']);
            $table->dropIndex(['thread_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['author_id']);
        });
    }
}
