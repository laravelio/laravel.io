<?php namespace Lio\Tags;

trait Taggable
{
    protected $updatedTagIds = null;

    public function setTagsById($updatedTagIds)
    {
        $this->updatedTagIds = $updatedTagIds;
    }

    public function hasUpdatedTags()
    {
        return ! is_null($this->updatedTagIds);
    }

    public function getUpdatedTagIds()
    {
        return $this->updatedTagIds;
    }

    public function tags()
    {
        return $this->belongsToMany('Lio\Tags\Tag', 'tagged_items', 'model_id', 'tag_id')->where('model_type', '=', get_class($this));
    }

    public function hasTagId($tagId)
    {
        return $this->tags->contains($tagId);
    }

    public function getTagSlugs()
    {
        return $this->tags->lists('slug');
    }
} 
