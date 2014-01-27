<?php

use Illuminate\Database\Migrations\Migration;

class ForumRepliesCreateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_replies', function($t) {
			$t->create();
			$t->increments('id');
			$t->text('body');
			$t->integer('author_id');
			$t->integer('thread_id');
			$t->timestamps();
			$t->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forum_replies');
	}

}