<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForumTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        $createdAt = new DateTime();

        DB::table('topics')->insert([
            'name' => 'General',
            'slug' => 'general',
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        Schema::table('threads', function(Blueprint $table) {
            $table->integer('topic_id')->default(1)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function(Blueprint $table) {
            $table->dropColumn('topic_id');
        });
        Schema::drop('topics');
    }
}
