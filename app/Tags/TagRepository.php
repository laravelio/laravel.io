<?php

namespace Lio\Tags;

interface TagRepository
{
    /**
     * @return \Lio\Tags\Tag[]
     */
    public function findAll();

    /**
     * @return \Lio\Forum\Thread|null
     */
    public function findBySlug(string $slug);
}
