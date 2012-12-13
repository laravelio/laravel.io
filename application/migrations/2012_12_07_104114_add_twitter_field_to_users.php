<?php

class Add_Twitter_Field_To_Users {

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
			$t->string('twitter');
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
		Schema::table('users', function($t)
		{
			$t->drop_column('twitter');
		});
	}

}