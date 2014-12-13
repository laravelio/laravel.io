<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ip', 100);
        });
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->string('ip', 100);
        });
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->string('ip', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ip');
        });
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropColumn('ip');
        });
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->dropColumn('ip');
        });
    }
}
