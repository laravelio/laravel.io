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
        Schema::dropIfExists('comments');
        Schema::dropIfExists('comment_tag');
        Schema::table('pastes', function (Blueprint $table) {
            $table->dropColumn('comment_count', 'child_count');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('forum');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
}
