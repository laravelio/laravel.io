<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToPastes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pastes', function($t) {
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
		Schema::table('pastes', function($t) {
			$t->dropColumn('deleted_at');
		});
	}

}
