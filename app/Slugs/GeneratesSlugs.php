<?php

namespace Lio\Slugs;

use Illuminate\Support\Str;

trait GeneratesSlugs
{
    public function generateUniqueSlug($value)
    {
        $slug = $originalSlug = Str::slug($value);
        $counter = 0;

        while ($this->model->where('slug', $slug)->count()) {
            $counter++;
            $slug = $originalSlug.'-'.$counter;
        }

        return $slug;
    }
}
