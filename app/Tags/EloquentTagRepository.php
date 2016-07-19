<?php

namespace Lio\Tags;

final class EloquentTagRepository implements TagRepository
{
    /**
     * @var \Lio\Tags\EloquentTag
     */
    private $model;

    public function __construct(EloquentTag $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Lio\Tags\Tag[]
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
