<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PastesAddHashField extends Migration
{
    public function up()
    {
        Schema::table('pastes', function (Blueprint $table) {
            $table->string('hash')->nullable();
        });
    }
}
