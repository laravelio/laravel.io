<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->text('body');

            $table->string('owner_type');
            $table->integer('owner_id');

            $table->integer('author_id');
            $table->integer('parent_id')->nullable();

            $table->integer('child_count')->default(0);
            $table->integer('most_recent_child_id')->nullable();

            $table->timestamps();
        });
    }
};
