<?php

use Illuminate\Database\Migrations\Migration;

class AddTypeFieldToComments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comments', function($t) {
			$t->integer('type');
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
			$t->dropColumn('type');
		});		
	}

}