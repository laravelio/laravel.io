<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTagTable extends Migration
{
    public function up()
    {
        Schema::create('comment_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comment_id')->index();
            $table->integer('tag_id')->index();

            $table->timestamps();
        });
    }
}
