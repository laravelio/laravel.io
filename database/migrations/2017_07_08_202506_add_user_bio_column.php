<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddUserBioColumn extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('bio', 160)->default('');
        });
    }
}
