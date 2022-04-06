<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('ip');
        });
        Schema::table('replies', function (Blueprint $table) {
            $table->dropColumn('ip');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ip');
        });
    }
};
