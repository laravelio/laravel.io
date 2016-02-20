<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUnusedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('activity');
        Schema::drop('forum_thread_visitations');
        Schema::drop('sessions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity', function(Blueprint $table) {
            $table->create();

            $table->increments('id');
            $table->integer('user_id');
            $table->integer('activity_type');
            $table->integer('activity_id');
            $table->text('description');

            $table->timestamps();
        });

        Schema::table('forum_thread_visitations', function(Blueprint $table) {
            $table->create();
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('thread_id');
            $table->timestamp('visited_at');
            $table->timestamps();
        });

        Schema::create('sessions', function(Blueprint $table) {
            $table->string('id')->unique();
            $table->text('payload');
            $table->integer('last_activity');
        });
    }
}
