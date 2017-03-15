<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('ip', 100)->default('');
        });

        Schema::table('forum_threads', function (Blueprint $table) {
            $table->string('ip', 100)->default('');
        });

        Schema::table('forum_replies', function (Blueprint $table) {
            $table->string('ip', 100)->default('');
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
