<?php
namespace Lio\Forum;

use Lio\Users\User;

interface ThreadRepository
{
    /**
     * @return \Lio\Forum\Thread[]|\Illuminate\Contracts\Pagination\Paginator
     */
    public function findAllPaginated();

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

    /**
     * @param \Lio\Users\User $author
     * @param string $subject
     * @param string $body
     * @param array $attributes
     * @return \Lio\Forum\Thread
     */
    public function create(User $author, $subject, $body, array $attributes = []);

    /**
     * @param \Lio\Forum\Thread $thread
     * @param array $attributes
     * @return \Lio\Forum\Thread
     */
    public function update(Thread $thread, array $attributes = []);

    /**
     * @param \Lio\Forum\Thread $thread
     */
    public function delete(Thread $thread);
}
