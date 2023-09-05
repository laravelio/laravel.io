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

    public function up(): void
    {
        foreach (self::TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $columnName = 'uuid';

                $table->uuid($columnName)
                    ->after('id')
                    ->index("{$tableName}_{$columnName}_index")
                    ->nullable();
            });
        }
    }
};
