<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPasswordAndUsernameFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->string('username', 40)->default('');
            $table->string('password')->default('');
        });

        // Copy name to username.
        DB::update('UPDATE users SET username = name');

        Schema::table('users', function(Blueprint $table) {
            $table->string('username', 40)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('username', 'password');
            $table->dropUnique('users_email_unique');
        });
    }
}
