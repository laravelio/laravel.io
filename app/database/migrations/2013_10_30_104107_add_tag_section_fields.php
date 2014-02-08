<?php

use Illuminate\Database\Migrations\Migration;

class AddTagSectionFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function($t) {
            $t->boolean('forum')->defaults(0);
            $t->boolean('articles')->defaults(0);
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
            $t->dropColumn('forum');
            $t->dropColumn('articles');
        });
    }

}
