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
}
