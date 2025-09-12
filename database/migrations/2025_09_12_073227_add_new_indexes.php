<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->index(['likeable_id', 'likeable_type']);
            $table->index(['likeable_id', 'likeable_type', 'created_at']);
        });

        Schema::table('taggables', function (Blueprint $table) {
            $table->dropIndex(['taggable_id']);

            $table->index(['taggable_id', 'taggable_type']);
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->dropIndex(['replyable_id']);
            $table->dropIndex(['replyable_type']);

            $table->index(['replyable_id', 'replyable_type']);
        });
    }
};
