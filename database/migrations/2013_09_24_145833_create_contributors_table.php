<?php

use Illuminate\Database\Migrations\Migration;

class CreateContributorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contributors', function($t) {
			$t->create();

			$t->increments('id');
			$t->integer('user_id')->nullable();
			$t->string('github_id');
			$t->string('name');
			$t->string('avatar_url');
			$t->string('github_url');
			$t->integer('contribution_count')->defaults(0);

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
		Schema::drop('contributors');
	}

}