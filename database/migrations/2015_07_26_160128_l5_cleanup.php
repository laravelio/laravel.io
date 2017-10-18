<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class L5Cleanup extends Migration
{
    public function up()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_tag');

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('articles');
        });
    }
}
