<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (DB::getDriverName() != 'sqlite') {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropForeign(['series_id']);
            });
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('series_id');
        });

        Schema::dropIfExists('series');
    }
};
