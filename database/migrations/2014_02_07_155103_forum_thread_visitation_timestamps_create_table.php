<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ForumThreadVisitationTimestampsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_thread_visitations');
    }
}
