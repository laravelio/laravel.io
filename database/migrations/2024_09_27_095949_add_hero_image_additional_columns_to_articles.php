<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->after('hero_image', function () use ($table) {
                $table->string('hero_image_url')->nullable();
                $table->string('hero_image_author_name')->nullable();
                $table->string('hero_image_author_url')->nullable();
            });
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->renameColumn('hero_image', 'hero_image_id');
        });
    }
};
