<?php

namespace App\Helpers;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    /**
     * @return \App\Models\Tag[]
     */
    public function tags()
    {
        return $this->tagsRelation;
    }

    public function syncTags(Tag ...$tags)
    {
        $this->save();
        $this->tagsRelation()->sync($tags);
    }

    public function removeTags()
    {
        $this->tagsRelation()->detach();
    }

    public function tagsRelation(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
}
