<?php

use Illuminate\Database\Migrations\Migration;

class ArticlesAddLaravelVerionField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('articles', function($t) {
			$t->integer('laravel_version')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('articles', function($t) {
			$t->dropColumn('laravel_version');
		});
	}

}
