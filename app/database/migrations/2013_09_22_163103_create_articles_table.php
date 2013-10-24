<?php

use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('articles', function($t) {
			$t->create();

			$t->increments('id');
			$t->integer('author_id');
			$t->string('title');
			$t->text('content');
			$t->boolean('featured')->defaults(0);

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
		Schema::drop('articles');
	}

}