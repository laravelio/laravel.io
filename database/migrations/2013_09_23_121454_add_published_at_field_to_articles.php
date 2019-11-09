<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPublishedAtFieldToArticles extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('status')->default(0);
            $table->dateTime('published_at')->nullable();
        });
    }
}
