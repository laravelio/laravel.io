<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function($table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('published_at');
            $table->integer('author_id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->integer('status');
            $table->boolean('featured');
        });

        // Schema::table('posts', function($table) {
        //     $table->foreign('author_id')->references('id')->on('users');
        // });

        Schema::create('tags', function($table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
        });

        Schema::create('post_tag', function($table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->integer('tag_id');
        });

        // Schema::table('post_tag', function($table) {
        //     $table->foreign('post_id')->references('id')->on('posts');
        //     $table->foreign('tag_id')->references('id')->on('tags');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
        Schema::drop('tags');
        Schema::drop('post_tag');
    }

}