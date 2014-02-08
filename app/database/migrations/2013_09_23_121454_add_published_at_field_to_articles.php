<?php

use Illuminate\Database\Migrations\Migration;

class AddPublishedAtFieldToArticles extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function($t) {
            $t->integer('status')->defaults(0);
            $t->dateTime('published_at')->nullable();
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
            $t->dropColumn('status');
            $t->dropColumn('published_at');
        });
    }

}
