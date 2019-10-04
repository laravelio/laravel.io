<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIpToPastesTable extends Migration
{
    public function up()
    {
        Schema::table('pastes', function (Blueprint $table) {
            $table->string('ip')->nullable();
        });
    }
}
