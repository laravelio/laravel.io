<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommentCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_categories', function($t) {
			$t->create();

			$t->increments('id');
			$t->string('title');
			$t->text('description');
			$t->integer('show_in_index')->defaults(0);
			$t->integer('comment_count')->defaults(0);

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
		Schema::drop('forum_categories');
	}

}