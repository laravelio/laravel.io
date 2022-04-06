<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
        });
    }
};
