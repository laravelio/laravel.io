<?php

use Illuminate\Database\Migrations\Migration;

class ForumThreadsCreateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_threads', function($t) {
			$t->create();
			$t->increments('id');
			$t->integer('author_id');
			$t->string('subject');
			$t->text('body');
			$t->string('slug');
			$t->string('category_slug');
			$t->integer('laravel_version');
			$t->integer('most_recent_reply_id');
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
		Schema::drop('forum_threads');
	}

}