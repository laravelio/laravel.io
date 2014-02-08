<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumThreadVisitationTimestampsCreateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_thread_visitations', function($t) {
            $t->create();
            $t->increments('id');
            $t->integer('user_id');
            $t->integer('thread_id');
            $t->timestamp('visited_at');
            $t->timestamps();
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
