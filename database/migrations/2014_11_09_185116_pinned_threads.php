<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PinnedThreads extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->boolean('pinned')->default(false);
        });
    }
}
