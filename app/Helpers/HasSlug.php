<?php

namespace App\Helpers;

trait HasSlug
{
    public function slug(): string
    {
        return $this->slug;
    }

    public function setSlugAttribute(string $slug)
    {
        $this->attributes['slug'] = $this->generateUniqueSlug($slug);
    }

    public static function findBySlug(string $slug): self
    {
        return static::where('slug', $slug)->firstOrFail();
    }

    private function generateUniqueSlug(string $value): string
    {
        $slug = $originalSlug = str_slug($value);
        $counter = 0;

        while ($this->slugExists($slug, $this->exists ? $this->id() : null)) {
            $counter++;
            $slug = $originalSlug.'-'.$counter;
        }

        return $slug;
    }

    private function slugExists(string $slug, int $ignoreId = null): bool
    {
        $query = $this->where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->count();
    }
}
