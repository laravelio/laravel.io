<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagTable extends Migration
{
    public function up()
    {
        Schema::create('article_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->index();
            $table->integer('tag_id')->index();

            $table->timestamps();
        });
    }
}
