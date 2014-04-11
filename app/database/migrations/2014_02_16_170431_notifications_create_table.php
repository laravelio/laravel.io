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
            $t->integer('user_id')->index();
            $t->string('class')->index();
            $t->string('model_type');
            $t->integer('model_id')->index();
            $t->text('extra_data');
            $t->boolean('is_read');
            $t->string('message');
            $t->string('link');
            $t->timestamp('read_at');
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
