<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalUsersDataFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company')->nullable()->index();
            $table->string('job_title')->nullable()->index();
            $table->boolean('list_on_public_directory')->default(false);
            $table->string('twitter_username')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('keep_mobile_private')->default(true);
            $table->boolean('mobile_verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company', 'job_title', 'list_on_public_directory', 'twitter_username', 'mobile', 'keep_mobile_private', 'mobile_verified']);
        });
    }
}
