<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('tweet_id')->after('is_pinned')->nullable();
            $table->dateTime('shared_at')->after('approved_at')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter')->after('email')->nullable();
        });
    }
};
