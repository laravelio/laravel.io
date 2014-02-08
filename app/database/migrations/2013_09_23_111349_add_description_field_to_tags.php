<?php

use Illuminate\Database\Migrations\Migration;

class AddDescriptionFieldToTags extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function($t) {
            $t->text('description');
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
            $t->dropColumn('description');
        });
    }

}
