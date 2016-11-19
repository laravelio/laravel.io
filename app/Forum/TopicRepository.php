<?php

namespace App\Forum;

class TopicRepository
{
    /**
     * @var \App\Forum\Topic
     */
    private $model;

    public function __construct(Topic $model)
    {
        $this->model = $model;
    }

    /**
     * @return \App\Forum\Topic[]
     */
    public function findAll()
    {
        return $this->model->all();
    }

    public function find($id): Topic
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug(string $slug): Topic
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
}
