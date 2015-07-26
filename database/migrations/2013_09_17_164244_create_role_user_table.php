<?php

use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('role_user', function($t) {
            $t->increments('id');
            $t->integer('user_id');
            $t->integer('role_id');
            $t->index('user_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('role_user');
	}
}
