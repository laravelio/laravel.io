<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributorsTable extends Migration
{
    public function up()
    {
        Schema::create('contributors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('github_id');
            $table->string('name');
            $table->string('avatar_url');
            $table->string('github_url');
            $table->integer('contribution_count')->default(0);

            $table->timestamps();
        });
    }
}
