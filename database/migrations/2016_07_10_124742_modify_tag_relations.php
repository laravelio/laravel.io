<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTagRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('tagged_items', 'taggables');

        Schema::table('taggables', function(Blueprint $table) {
            $table->renameColumn('thread_id', 'taggable_id');
        });

        Schema::table('taggables', function(Blueprint $table) {
            $table->string('taggable_type')->default('');
        });

        DB::table('taggables')->update(['taggable_type' => 'threads']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taggables', function(Blueprint $table) {
            $table->renameColumn('taggable_id', 'thread_id');
        });

        Schema::table('taggables', function(Blueprint $table) {
            $table->dropColumn('taggable_type');
        });

        Schema::rename('taggables', 'tagged_items');
    }
}
