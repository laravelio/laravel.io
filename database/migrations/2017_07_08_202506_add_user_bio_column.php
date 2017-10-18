<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddUserBioColumn extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('bio', 160)->default('');
        });
    }
}
