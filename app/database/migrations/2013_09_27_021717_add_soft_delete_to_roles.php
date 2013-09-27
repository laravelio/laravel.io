<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('roles', function($t) {
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
		Schema::table('roles', function($t) {
			$t->dropColumn('deleted_at');
		});
	}

}
