<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Spam
{
    public function spamReporters(): Collection;

    public function spamReportersRelation(): MorphToMany;
}
