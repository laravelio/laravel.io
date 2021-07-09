<?php

declare(strict_types=1);

namespace App\Helpers;

trait UsesFilters
{
    public function getFilter(string $default = 'recent'): string
    {
        $filter = (string) request('filter');

        return in_array($filter, ['recent', 'resolved', 'unresolved']) ? $filter : $default;
    }
}
