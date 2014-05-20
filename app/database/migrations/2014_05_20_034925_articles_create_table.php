<?php

use Illuminate\Database\Migrations\Migration;

class ArticlesCreateTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function($t) {
            $t->increments('id');
            $t->integer('author_id');
            $t->string('slug')->nullable();
            $t->string('title');
            $t->text('content');
            $t->boolean('featured')->defaults(0);
            $t->integer('status')->default('0');
            $t->integer('laravel_version')->default(0);
            $t->integer('comment_count')->default(0);
            $t->timestamp('published_at')->nullable();
            $t->timestamps();
            $t->softDelets();
        });
    }

    public function down()
    {
        Schema::drop('articles');
    }
}
