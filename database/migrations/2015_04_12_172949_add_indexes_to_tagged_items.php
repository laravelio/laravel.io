<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToTaggedItems extends Migration
{
    public function up()
    {
        Schema::table('tagged_items', function (Blueprint $table) {
            $table->index('thread_id');
            $table->index('tag_id');
        });
    }
}
