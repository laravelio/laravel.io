<?php

namespace App\Helpers;

use App\Tags\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait UsesTags
{
    /**
     * @return \App\Tags\Tag[]
     */
    public function tags()
    {
        return $this->tagsRelation;
    }

    public function tagsRelation(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggables', null, 'tag_id')
            ->withTimestamps();
    }
}
