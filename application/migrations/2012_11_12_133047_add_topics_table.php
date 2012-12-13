<?php

class Add_Topics_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('topics', function($t)
		{
			$t->create();
			
			$t->increments('id');

			$t->integer('user_id');
			$t->string('title');
			$t->text('body');
			$t->integer('status')->defaults(0);

			$t->index('user_id');
			$t->index('status');

			$t->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('topics');
	}

}