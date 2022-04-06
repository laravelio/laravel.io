<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_id')->nullable()->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_username')->nullable()->change();
        });

        if (! app()->runningUnitTests()) {
            DB::table('users')->where('github_id', '')->update(['github_id' => null]);
            DB::table('users')->where('github_username', '')->update(['github_username' => null]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('github_id');
        });
    }
};
