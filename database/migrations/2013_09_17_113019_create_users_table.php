<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('github_id')->default('');
            $table->string('github_url')->default('');
            $table->string('email');
            $table->string('name');

            $table->timestamps();
        });
    }
}
