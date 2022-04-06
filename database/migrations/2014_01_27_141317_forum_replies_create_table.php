<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('author_id');
            $table->integer('thread_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
