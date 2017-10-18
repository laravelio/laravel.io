<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastesTable extends Migration
{
    public function up()
    {
        Schema::create('pastes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->text('code');
            $table->integer('comment_count');
            $table->integer('child_count');

            $table->timestamps();
        });
    }
}
