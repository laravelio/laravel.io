<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIndexesToTaggedItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagged_items', function (Blueprint $table) {
            $table->index('thread_id');
            $table->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagged_items', function (Blueprint $table) {
            $table->dropIndex(['thread_id']);
            $table->dropIndex(['tag_id']);
        });
    }
}
