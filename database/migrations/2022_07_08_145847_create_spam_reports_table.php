<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spam_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reporter_id');
            $table->foreign('reporter_id')->references('id')->on('users')->cascadeOnDelete();
            $table->nullableMorphs('spam');
            $table->timestamps();

            $table->unique(['reporter_id', 'spam_id', 'spam_type']);
        });
    }
};
