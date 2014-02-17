<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationsCreateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('notifications', function($t) {
            $t->create();
            $t->increments('id');
            $t->integer('user_id');
            $t->string('class');
            $t->string('subject_type')->nullable();
            $t->integer('subject_id')->nullable();
            $t->softDeletes();
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
		Schema::drop('notifications');
	}

}
