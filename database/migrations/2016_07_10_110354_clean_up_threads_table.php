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
            $table->integer('solution_reply_id')->unsigned()->change();
            $table->foreign('solution_reply_id')
                ->references('id')->on('replies')
                ->onDelete('set null');
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
            $table->dropForeign(['solution_reply_id']);
            $table->boolean('is_question')->default(true);
            $table->boolean('pinned')->default(false);
            $table->integer('laravel_version')->default(0);
            $table->dropUnique(['slug']);
        });
    }
}
