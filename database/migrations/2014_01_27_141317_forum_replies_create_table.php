<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ForumRepliesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_replies', function(Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('author_id');
            $table->integer('thread_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
