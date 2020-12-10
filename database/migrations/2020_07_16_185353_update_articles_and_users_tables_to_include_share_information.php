<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticlesAndUsersTablesToIncludeShareInformation extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dateTime('shared_at')->after('approved_at')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter')->after('email')->nullable();
        });
    }
}
