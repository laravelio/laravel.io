<?php
namespace Lio\Forum;

interface ThreadRepository
{
    /**
     * @return \Lio\Forum\Thread[]
     */
    public function findAll();

    /**
     * @param string $slug
     * @return \Lio\Forum\Thread|null
     */
    public function findBySlug($slug);
}
