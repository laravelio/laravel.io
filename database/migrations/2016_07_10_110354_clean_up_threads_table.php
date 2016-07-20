<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanUpThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('is_question', 'pinned', 'laravel_version');
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function(Blueprint $table) {
            $table->boolean('is_question')->default(true);
            $table->boolean('pinned')->default(false);
            $table->integer('laravel_version')->default(0);
            $table->dropUnique('threads_slug_unique');
        });
    }
}
