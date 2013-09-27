<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToTags extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tags', function($t) {
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
		Schema::table('tags', function($t) {
			$t->dropColumn('deleted_at');
		});
	}

}
