<?php

use Illuminate\Database\Migrations\Migration;

class ArticleCommentsCreateTable extends Migration
{
    public function up()
    {
        Schema::create('article_comments', function($t) {
            $t->increments('id');
            $t->integer('article_id');
            $t->integer('author_id');
            $t->text('content');
            $t->timestamps();
            $t->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('article_comments');
    }
}
