<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Spam
{
    public function spamReporters(): MorphToMany;
}
