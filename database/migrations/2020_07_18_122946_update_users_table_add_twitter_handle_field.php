<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableAddTwitterHandleField extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter_handle')->after('email')->nullable();
        });
    }
}
