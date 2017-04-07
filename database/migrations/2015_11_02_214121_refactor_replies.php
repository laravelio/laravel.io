<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('forum_replies', 'replies');
        Schema::rename('forum_threads', 'threads');

        Schema::table('replies', function (Blueprint $table) {
            $table->renameColumn('thread_id', 'replyable_id');
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->string('replyable_type')->default('');
        });
    }
}
