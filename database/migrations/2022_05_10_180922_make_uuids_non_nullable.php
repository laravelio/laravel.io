<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public const TABLES = [
        'articles',
        'threads',
        'replies',
    ];

    public function up()
    {
        foreach (self::TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropIndex($tableName.'_uuid_index');

                $table->uuid('uuid')
                    ->nullable(false)
                    ->unique()
                    ->change();
            });
        }
    }
};
