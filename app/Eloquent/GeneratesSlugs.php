<?php

namespace Lio\Eloquent;

use Illuminate\Support\Str;

trait GeneratesSlugs
{
    public function generateUniqueSlug(string $value, int $ignoreId = null)
    {
        $slug = $originalSlug = Str::slug($value);
        $counter = 0;

        while ($this->slugExists($slug, $ignoreId)) {
            $counter++;
            $slug = $originalSlug.'-'.$counter;
        }

        return $slug;
    }

    private function slugExists(string $slug, int $ignoreId = null): bool
    {
        $query = $this->model->where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->count();
    }
}
