<?php

use Illuminate\Database\Migrations\Migration;

class CreateSlugsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('slugs', function($t) {
			$t->create();

			$t->increments('id');
			$t->string('slug');
			$t->integer('owner_id');
			$t->string('owner_type');
			$t->integer('primary')->defaults(0);
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
		Schema::drop('slugs');
	}

}