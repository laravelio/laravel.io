<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * This interface allows models to receive spam.
 * 
 * @mixin \Illuminate\Database\Eloquent\Model
 */
interface SpamAble
{
    /**
     * @return MorphToMany
     */
    public function spammers();
}
