<?php

namespace App\Concerns;

use App\Models\EditLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use function sprintf;

trait HasEditLog
{
    public static function bootHasEditLog()
    {
        static::updating(function($model) {
            EditLog::create([
                'author_id' => auth()->id(),
                'editable_id' => $model->id,
                'editable_type' => $model::class,
                'edited_at' => now(),
            ]);

            $cacheKey = sprintf('%s-%s', Str::slug($model::class), $model->id);
            if(Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        });
    }

    public function editLogs(): MorphMany
    {
        return $this->morphMany(EditLog::class, 'editable');
    }

    public function getLatestEditLogAttribute()
    {
        $cacheKey = sprintf('%s-%s', Str::slug($this::class), $this->id);
        echo $cacheKey;

        //return Cache::rememberForever($cacheKey, function() {
            return $this->editLogs()->latest('edited_at')->first();
        //});
    }
}
