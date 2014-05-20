<?php

use Illuminate\Database\Migrations\Migration;

class CreateArticleTagTable extends Migration
{
	public function up()
	{
		Schema::create('article_tag', function($t) {
			$t->increments('id');
			$t->integer('article_id')->index();
			$t->integer('tag_id')->index();
			$t->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('article_tag');
	}
}
