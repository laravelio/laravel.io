<?php

use Illuminate\Database\Migrations\Migration;

class CommentsAddLaravelVersion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comments', function($t) {
			$t->integer('laravel_version')->defaults(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('comments', function($t) {
			$t->dropColumn('laravel_version');
		});
	}

}