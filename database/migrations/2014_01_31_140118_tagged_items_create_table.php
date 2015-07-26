<?php

use Illuminate\Database\Migrations\Migration;

class TaggedItemsCreateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tagged_items', function($t) {
			$t->create();

			$t->increments('id');
			$t->integer('thread_id');
			$t->integer('tag_id');

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
		Schema::drop('tagged_items');
	}

}