<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentTagTable extends Migration
{
    /**
     * Run the migrations.
     */
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
