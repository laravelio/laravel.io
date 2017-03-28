<?php

namespace App\Helpers;

trait HasSlug
{
    public static function findBySlug(string $slug): self
    {
        return static::where('slug', $slug)->firstOrFail();
    }

    private static function generateUniqueSlug(string $value, int $ignoreId = null): string
    {
        $slug = $originalSlug = str_slug($value);
        $counter = 0;

        while (static::slugExists($slug, $ignoreId)) {
            $counter++;
            $slug = $originalSlug.'-'.$counter;
        }

        return $slug;
    }

    private static function slugExists(string $slug, int $ignoreId = null): bool
    {
        $query = static::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->count();
    }
}
