<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ip', 100)->default('');
        });

        Schema::table('forum_threads', function (Blueprint $table) {
            $table->string('ip', 100)->default('');
        });

        Schema::table('forum_replies', function (Blueprint $table) {
            $table->string('ip', 100)->default('');
        });
    }
};
