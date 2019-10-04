<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumThreadVisitationTimestampsCreateTable extends Migration
{
    public function up()
    {
        Schema::table('forum_thread_visitations', function (Blueprint $table) {
            $table->create();
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('thread_id');
            $table->timestamp('visited_at');
            $table->timestamps();
        });
    }
}
