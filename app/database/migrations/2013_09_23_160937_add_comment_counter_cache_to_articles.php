<?php

use Illuminate\Database\Migrations\Migration;

class AddCommentCounterCacheToArticles extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function($t) {
            $t->integer('comment_count')->defaults(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function($t) {
            $t->dropColumn('comment_count');
        });
    }

}
