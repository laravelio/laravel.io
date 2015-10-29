<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedDbTablesAndColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropColumn('category_slug', 'most_recent_reply_id', 'reply_count');
        });
        Schema::drop('comments');
        Schema::drop('comment_tag');
        Schema::table('pastes', function (Blueprint $table) {
            $table->dropColumn('comment_count', 'child_count');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('forum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->string('category_slug')->default('');
            $table->integer('most_recent_reply_id')->default(0);
            $table->index('most_recent_reply_id');
            $table->integer('reply_count')->default(0);
        });

        Schema::create('comments', function(Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->text('body');

            $table->string('owner_type');
            $table->integer('owner_id');

            $table->integer('author_id');
            $table->index('author_id');
            $table->integer('parent_id')->nullable();

            $table->integer('child_count')->default(0);
            $table->integer('most_recent_child_id')->nullable();
            $table->integer('type')->default(0);
            $table->integer('laravel_version')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('comment_tag', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('comment_id')->index();
            $table->integer('tag_id')->index();

            $table->timestamps();
        });

        Schema::table('pastes', function (Blueprint $table) {
            $table->integer('comment_count')->default(0);
            $table->integer('child_count')->default(0);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->smallInteger('forum')->default(0);
        });
    }
}
