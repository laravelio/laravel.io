<?php

class Add_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('users', function($t)
		{
			$t->create();
			
			$t->increments('id');

			$t->string('name');
			$t->string('email');
			$t->integer('guest')->defaults(0);

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
		Schema::drop('users');
	}

}