<?php
namespace Lio\Forum;

interface ThreadRepository
{
    /**
     * @return \Lio\Forum\Thread[]
     */
    public function findAll();

    /**
     * @param int $id
     * @return \Lio\Forum\Thread|null
     */
    public function find($id);

    /**
     * @param string $slug
     * @return \Lio\Forum\Thread|null
     */
    public function findBySlug($slug);
}
