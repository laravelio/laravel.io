<?php

namespace Lio\Tags;

interface TagRepository
{
    /**
     * @return \Lio\Tags\Tag[]
     */
    public function findAll();
    public function findBySlug(string $slug): Tag;
}
