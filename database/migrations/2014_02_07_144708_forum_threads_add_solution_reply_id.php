<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumThreadsAddSolutionReplyId extends Migration
{
    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->integer('solution_reply_id')->nullable()->default(null);
        });
    }
}
