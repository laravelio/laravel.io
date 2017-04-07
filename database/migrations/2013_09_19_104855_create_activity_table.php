<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('activity_type');
            $table->integer('activity_id');
            $table->text('description');

            $table->timestamps();
        });
    }
}
