<?php

namespace App\Tags;

interface TagRepository
{
    /**
     * @return \App\Tags\Tag[]
     */
    public function findAll();
    public function findBySlug(string $slug): Tag;
}
