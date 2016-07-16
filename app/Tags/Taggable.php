<?php

namespace Lio\Tags;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Taggable
{
    /**
     * @return \Lio\Tags\Tag[]
     */
    public function tags();
    public function tagsRelation(): MorphToMany;
}
