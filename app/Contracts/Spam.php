<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Collection;

interface Spam
{
    public function spamReporters(): Collection;

    public function spamReportersRelation(): MorphToMany;
}
