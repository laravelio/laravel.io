<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionFieldToTags extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->text('description')->nullable();
        });
    }
}
