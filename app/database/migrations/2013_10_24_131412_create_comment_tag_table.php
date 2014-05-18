<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommentTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comment_tag', function($t) {
			$t->create();

			$t->increments('id');
			$t->integer('comment_id')->index();
			$t->integer('tag_id')->index();

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
		Schema::drop('comment_tag');
	}

}