<?php

use Illuminate\Database\Migrations\Migration;

class AddCategorySlugFieldToComments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comments', function($t) {
			$t->string('category_slug')->nullable();
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
			$t->dropColumn('category_slug');
		});
	}

}