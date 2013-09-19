<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comments', function($t) {
			$t->create();

			$t->increments('id');
			$t->string('owner_type');
			$t->integer('owner_id');

			$t->integer('author_id');
			$t->integer('parent_id')->nullable();

			$t->integer('child_count')->defaults(0);
			$t->integer('most_recent_child_id')->nullable();

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
		Schema::drop('comments');
	}

}