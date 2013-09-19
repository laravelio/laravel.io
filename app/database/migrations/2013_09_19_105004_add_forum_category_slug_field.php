<?php

use Illuminate\Database\Migrations\Migration;

class AddForumCategorySlugField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_categories', function($t) {
			$t->string('slug');
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
			$t->dropColumn('slug');
		});
	}

}