<?php

namespace App\Helpers;

trait UsesFilters
{
    public function getFilter($default = 'recent')
    {
        $filter = (string) request('filter');

        return in_array($filter, ['recent', 'resolved', 'active']) ? $filter : $default;
    }
}
