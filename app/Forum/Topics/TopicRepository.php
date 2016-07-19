<?php

namespace Lio\Forum\Topics;

interface TopicRepository
{
    /**
     * @return \Lio\Forum\Topics\Topic[]
     */
    public function findAll();

    public function find($id): Topic;
    public function findBySlug(string $slug): Topic;
}
