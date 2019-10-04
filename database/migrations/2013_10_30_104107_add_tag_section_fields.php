<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagSectionFields extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->smallInteger('forum')->default(0);
            $table->smallInteger('articles')->default(0);
        });
    }
}
