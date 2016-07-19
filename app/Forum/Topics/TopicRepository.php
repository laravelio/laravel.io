<?php

namespace Lio\Forum\Topics;

interface TopicRepository
{
    /**
     * @return \Lio\Forum\Topics\Topic[]
     */
    public function findAll();

    /**
     * @return \Lio\Forum\Topics\Topic|null
     */
    public function find($id);

    /**
     * @return \Lio\Forum\Topics\Topic|null
     */
    public function findBySlug(string $slug);
}
