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

    /**
     * @param \App\Models\Tag[]|int[] $tags
     */
    public function syncTags(array $tags)
    {
        $this->save();
        //add any new tags to the list
        foreach($tags as $tagIndex => $tag) {

            if(!is_numeric($tag) && Tag::whereSlug(strtolower($tag))->count() === 0) {
                $tagModel = Tag::create([
                    'name' => ucfirst($tag),
                    'slug' => strtolower($tag)
                ]);

                $tags[$tagIndex] = $tagModel->id;
            }
        }
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
