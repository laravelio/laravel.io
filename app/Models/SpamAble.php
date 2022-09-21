<?php

namespace App\Models;

interface SpamAble
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function spammers();
}
