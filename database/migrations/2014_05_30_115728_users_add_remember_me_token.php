<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddRememberMeToken extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('remember_token')->default('');
        });
    }
}
