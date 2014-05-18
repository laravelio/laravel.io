<?php

use Illuminate\Database\Migrations\Migration;

class CreatePastesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pastes', function($t) {
			$t->create();

			$t->increments('id');
			$t->integer('author_id')->nullable();
			$t->integer('parent_id')->nullable();
			$t->text('description')->nullable();
			$t->text('code');
			$t->integer('comment_count');
			$t->integer('child_count');

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
		Schema::drop('pastes');
	}

}