<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToForumCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_categories', function($t) {
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
		Schema::table('forum_categories', function($t) {
			$t->dropColumn('deleted_at');
		});
	}

}
