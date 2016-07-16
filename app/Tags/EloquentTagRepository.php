<?php

namespace Lio\Tags;

class EloquentTagRepository implements TagRepository
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

    /**
     * @return \Lio\Tags\Tag|null
     */
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
