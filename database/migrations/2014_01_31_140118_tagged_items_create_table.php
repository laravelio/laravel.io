<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaggedItemsCreateTable extends Migration
{
    public function up()
    {
        Schema::create('tagged_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id');
            $table->integer('tag_id');

            $table->timestamps();
        });
    }
}
