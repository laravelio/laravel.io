<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('activity_type');
            $table->integer('activity_id');
            $table->text('description');

            $table->timestamps();
        });
    }
}
