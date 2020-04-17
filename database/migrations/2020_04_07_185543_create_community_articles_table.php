<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('series_id')->nullable();
            $table->unsignedInteger('author_id');
            $table->string('title');
            $table->text('body');
            $table->string('canonical_url')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreign('series_id')
                ->references('id')->on('series')
                ->onDelete('CASCADE');

            $table->foreign('author_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
