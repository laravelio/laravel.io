<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResolvedByToThreadsTable extends Migration
{
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->integer('resolved_by')->unsigned()->nullable()->default(null);
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }
}
