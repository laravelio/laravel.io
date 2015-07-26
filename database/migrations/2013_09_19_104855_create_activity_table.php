<?php

use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity', function($t) {
            $t->create();

            $t->increments('id');
            $t->integer('user_id');
            $t->integer('activity_type');
            $t->integer('activity_id');
            $t->text('description');

            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activity');
    }
}
