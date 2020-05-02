<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropUnusedTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('activity');
        Schema::dropIfExists('forum_thread_visitations');
        Schema::dropIfExists('sessions');
    }
}
