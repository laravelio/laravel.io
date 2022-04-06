<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public const MODEL_CLASSES = [
        \App\Models\Article::class,
        \App\Models\Thread::class,
        \App\Models\Reply::class,
    ];

    public function up(): void
    {
        foreach (static::MODEL_CLASSES as $classname) {
            $model = new $classname;

            Schema::table($model->getTable(), function (Blueprint $table) use ($model) {
                $columnName = 'uuid';

                $table->uuid($columnName)
                    ->after('id')
                    ->index("{$model->getTable()}_{$columnName}_index")
                    ->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (static::MODEL_CLASSES as $classname) {
            $model = new $classname;

            Schema::table($model->getTable(), function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
};
