<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('activity');
        Schema::dropIfExists('forum_thread_visitations');
        Schema::dropIfExists('sessions');
    }
};
