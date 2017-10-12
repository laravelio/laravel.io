<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class L5Cleanup extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_tag');

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('articles');
        });
    }
}
