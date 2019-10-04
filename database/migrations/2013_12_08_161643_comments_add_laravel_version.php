<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommentsAddLaravelVersion extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('laravel_version')->default(0);
        });
    }
}
