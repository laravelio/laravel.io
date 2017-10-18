<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PinnedThreads extends Migration
{
    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->boolean('pinned')->default(false);
        });
    }
}
