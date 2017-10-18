<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->string('title');
            $table->text('content');
            $table->boolean('featured')->default(0);

            $table->timestamps();
        });
    }
}
