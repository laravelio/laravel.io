<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableAddTwitterHandleField extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter_handle')->after('email')->nullable();
        });
    }
}
