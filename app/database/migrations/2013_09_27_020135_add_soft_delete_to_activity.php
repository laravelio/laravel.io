<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToActivity extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activity', function($t) {
			$t->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activity', function($t) {
			$t->dropColumn('deleted_at');
		});
	}

}
