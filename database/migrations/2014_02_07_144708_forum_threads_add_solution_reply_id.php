<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ForumThreadsAddSolutionReplyId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->integer('solution_reply_id')->nullable()->default(null);
        });
    }
}
