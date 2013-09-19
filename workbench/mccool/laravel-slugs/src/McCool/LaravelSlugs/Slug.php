<?php namespace McCool\LaravelSlugs;

use Eloquent;

class Slug extends Eloquent
{
    protected $table = 'slugs';
    protected $fillable = ['primary', 'slug', 'owner_id', 'owner_type'];

    public function model()
    {
        return $this->morphTo('owner');
    }

    public function getPrimarySlugByHistoricalSlug($slug)
    {
        return static::where('owner_type', '=', $slug->owner_type)
            ->where('owner_id', '=', $slug->owner_id)
            ->where('primary', '=', 1)
            ->first();
    }

    public function getByString($slug)
    {
        return static::where('slug', '=', $slug)->first();
    }
}