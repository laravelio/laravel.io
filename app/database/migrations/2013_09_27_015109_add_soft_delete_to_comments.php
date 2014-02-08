<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToComments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function($t) {
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
        Schema::table('comments', function($t) {
            $t->dropColumn('deleted_at');
        });
    }

}
