<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserActivityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('user_actvities', function($table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('activity_type');
            $table->integer('activity_id');
            $table->text('description');
        });

        // Schema::table('user_actvities', function($table) {
        //     $table->foreign('user_id')->references('id')->on('users');
        // });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_actvities');
	}

}