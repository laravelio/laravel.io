<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const MODEL_CLASSES = [
        \App\Models\Article::class,
        \App\Models\Thread::class,
//        \App\Models\Reply::class,
    ];

    private const UUID_FIELD = 'uuid';
    private const UUID_FIELD_AFTER =  'id';

    public function up(): void
    {
        foreach (static::MODEL_CLASSES as $classname) {
            $model = new $classname;

            Schema::table($model->getTable(), function (Blueprint $table) use ($model) {
                $columnName = static::UUID_FIELD;

                $table->uuid($columnName)
                    ->after(static::UUID_FIELD_AFTER)
                    ->index("{$model->getTable()}_{$columnName}_index")
                    ->nullable();
            });

            $this->performUpsert($model);

            Schema::table($model->getTable(), function (Blueprint $table) {
                $table->uuid(static::UUID_FIELD)
                    ->nullable(false)
                    ->change();
            });
        }
    }

    protected function performUpsert(Model $model): void
    {
        $query = $model->newQuery();

        if (method_exists($query, 'withTrashed')) {
            $query->withTrashed();
        }

        $query->chunk(1000, function ($chunk) {
            $chunk->each(function ($model) {
                $model->uuid = \Illuminate\Support\Str::uuid();
                $model->save();
            });
        });
    }

    public function down(): void
    {
        foreach (static::MODEL_CLASSES as $classname) {
            $model = new $classname;

            Schema::table($model->getTable(), function (Blueprint $table) {
                $table->dropColumn(static::UUID_FIELD);
            });
        }
    }
};
