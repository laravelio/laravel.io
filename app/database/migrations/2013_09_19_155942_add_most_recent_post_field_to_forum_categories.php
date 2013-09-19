<?php

use Illuminate\Database\Migrations\Migration;

class AddMostRecentPostFieldToForumCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_categories', function($t) {
			$t->integer('most_recent_child_id')->nullable();
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
			$t->dropColumn('most_recent_child_id');
		});
	}

}