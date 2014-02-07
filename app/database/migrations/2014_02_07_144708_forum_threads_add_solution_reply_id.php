<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumThreadsAddSolutionReplyId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_threads', function($t) {
           $t->integer('solution_reply_id')->nullable()->defaults(null);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('forum_threads', function($t) {
            $t->dropColumn('solution_reply_id');
        });
	}

}
