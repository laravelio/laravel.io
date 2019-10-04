<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticlesAddLaravelVerionField extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('laravel_version')->default(0);
        });
    }
}
