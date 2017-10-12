<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
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
