<?php

namespace App\Tags;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface TagAble
{
    /**
     * @return \App\Tags\Tag[]
     */
    public function tags();
    public function tagsRelation(): MorphToMany;
}
