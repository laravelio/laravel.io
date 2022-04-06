<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->timestamp('locked_at')->nullable()->default(null);
            $table->integer('locked_by')->unsigned()->nullable()->default(null);

            $table->foreign('locked_by')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');
        });
    }
};
