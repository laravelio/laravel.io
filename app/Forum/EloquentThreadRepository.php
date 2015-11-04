<?php
namespace Lio\Forum;

final class EloquentThreadRepository implements ThreadRepository
{
    /**
     * @var \Lio\Forum\EloquentThread
     */
    private $model;

    /**
     * @param \Lio\Forum\EloquentThread $model
     */
    public function __construct(EloquentThread $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Lio\Forum\Thread[]
     */
    public function findAll()
    {
        return $this->model->get();
    }

    /**
     * @param int $id
     * @return \Lio\Forum\Thread|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param string $slug
     * @return \Lio\Forum\Thread|null
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
