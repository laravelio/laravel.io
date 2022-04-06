<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('banned_at')->nullable();
        });

        User::where('is_banned', 1)->each(function ($user) {
            $user->banned_at = $user->updated_at;
            $user->save();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_banned');
        });
    }
};
