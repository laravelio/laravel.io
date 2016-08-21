<?php

namespace App\Forum\Topics;

interface TopicRepository
{
    /**
     * @return \App\Forum\Topics\Topic[]
     */
    public function findAll();

    public function find($id): Topic;
    public function findBySlug(string $slug): Topic;
}
