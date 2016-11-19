<?php

namespace App\Tags;

class TagRepository
{
    /**
     * @var \App\Tags\Tag
     */
    private $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    /**
     * @return \App\Tags\Tag[]
     */
    public function findAll()
    {
        return $this->model->all();
    }

    public function findBySlug(string $slug): Tag
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
}
