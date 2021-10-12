<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLockedByColumnToThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->integer('locked_by')->unsigned()->nullable()->default(null);
            $table->foreign('locked_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }
}
