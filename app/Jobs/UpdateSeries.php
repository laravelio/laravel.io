<?php

namespace App\Jobs;

use App\Http\Requests\SeriesRequest;
use App\Models\Series;
use Illuminate\Support\Arr;

final class UpdateSeries
{
    private $series;

    private $attributes;

    public function __construct(Series $series, array $attributes = [])
    {
        $this->series = $series;
        $this->attributes = Arr::only($attributes, ['title', 'slug', 'tags']);
    }

    public static function fromRequest(Series $series, SeriesRequest $request): self
    {
        return new static($series, [
            'title' => $request->title(),
            'slug' => $request->title(),
            'tags' => $request->tags(),
        ]);
    }

    public function handle(): Series
    {
        $this->series->update($this->attributes);

        if (Arr::has($this->attributes, 'tags')) {
            $this->series->syncTags($this->attributes['tags']);
        }

        $this->series->save();

        return $this->series;
    }
}
