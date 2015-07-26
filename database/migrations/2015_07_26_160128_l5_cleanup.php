<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class L5Cleanup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('articles');
        Schema::drop('article_tag');

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->string('title');
            $table->text('content');
            $table->boolean('featured')->defaults(0);
            $table->integer('status')->defaults(0);
            $table->dateTime('published_at')->nullable();
            $table->integer('comment_count')->defaults(0);
            $table->integer('laravel_version')->defaults(0);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('article_tag', function(Blueprint $table) {
            $table->create();

            $table->increments('id');
            $table->integer('article_id')->index();
            $table->integer('tag_id')->index();

            $table->timestamps();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->boolean('articles')->defaults(0);
        });
    }
}
