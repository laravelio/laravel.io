<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToContributors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contributors', function($t) {
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
		Schema::table('contributors', function($t) {
			$t->dropColumn('deleted_at');
		});
	}

}
