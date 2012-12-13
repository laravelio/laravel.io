<?php

class Add_Tags_Tables {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('tags', function($t)
		{
			$t->create();

			$t->increments('id');

			$t->string('name');
			$t->string('slug');

			$t->timestamps();
		});

		Schema::table('tag_topic', function($t)
		{
			$t->create();

			$t->increments('id');

			$t->integer('tag_id');
			$t->integer('topic_id');
			$t->integer('type')->defaults(0);

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
		Schema::drop('tags');
		Schema::drop('tag_topic');
	}

}