<?php

declare(strict_types=1);

namespace App\Concerns;

trait UsesFilters
{
    public function getFilter(array $options = ['recent', 'resolved', 'unresolved'], string $default = 'recent'): string
    {
        $filter = (string) request('filter');

        return in_array($filter, $options) ? $filter : $default;
    }
}
