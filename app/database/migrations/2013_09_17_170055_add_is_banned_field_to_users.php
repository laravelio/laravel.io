<?php

use Illuminate\Database\Migrations\Migration;

class AddIsBannedFieldToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('users', function($t) {
			$t->integer('is_banned')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('users', function($t) {
			$t->dropColumn('is_banned');
		});
	}

}
