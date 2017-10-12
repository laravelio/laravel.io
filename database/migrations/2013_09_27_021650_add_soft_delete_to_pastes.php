<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSoftDeleteToPastes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pastes', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
