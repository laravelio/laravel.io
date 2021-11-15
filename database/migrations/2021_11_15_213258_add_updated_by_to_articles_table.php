<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedByToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('updated_by')->nullable();
        });

        Schema::table('threads', function (Blueprint $table) {
            $table->foreignId('updated_by')->nullable();
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->foreignId('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });

        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
}
