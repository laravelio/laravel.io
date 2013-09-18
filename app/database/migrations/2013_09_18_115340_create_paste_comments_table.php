<?php

use Illuminate\Database\Migrations\Migration;

class CreatePasteCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('paste_comments', function($t) {
			$t->create();

			$t->increments('id');
			$t->integer('author_id');
			$t->text('comment');

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
		Schema::drop('paste_comments');
	}
}
