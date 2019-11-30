<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('likeable_id');
            $table->string('likeable_type');
            $table->timestamps();
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->index(['user_id', 'uuid']);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
        });
    }
}
