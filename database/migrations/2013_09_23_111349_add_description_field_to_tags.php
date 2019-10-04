<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDescriptionFieldToTags extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->text('description')->nullable();
        });
    }
}
