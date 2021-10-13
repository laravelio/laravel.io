<?php

namespace App\Concerns;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function tags()
    {
        return $this->tagsRelation;
    }

    /**
     * @param  \App\Models\Tag[]|int[]  $tags
     */
    public function syncTags(array $tags)
    {
        $this->save();
        $this->tagsRelation()->sync($tags);

        $this->unsetRelation('tagsRelation');
    }

    public function removeTags()
    {
        $this->tagsRelation()->detach();

        $this->unsetRelation('tagsRelation');
    }

    public function tagsRelation(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
}
