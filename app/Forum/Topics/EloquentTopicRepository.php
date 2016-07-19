<?php

namespace Lio\Forum\Topics;

final class EloquentTopicRepository implements TopicRepository
{
    /**
     * @var \Lio\Forum\Topics\EloquentTopic
     */
    private $model;

    public function __construct(EloquentTopic $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Lio\Forum\Topics\Topic[]
     */
    public function findAll()
    {
        return $this->model->all();
    }

    /**
     * @return \Lio\Forum\Topics\Topic|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @return \Lio\Forum\Topics\Topic|null
     */
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
