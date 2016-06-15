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
     * @return \Lio\Forum\Thread|null
     */
    public function find(int $id);

    /**
     * @return \Lio\Forum\Thread|null
     */
    public function findBySlug(string $slug);

    public function create(User $author, string $subject, string $body, array $attributes = []): Thread;
    public function update(Thread $thread, array $attributes = []): Thread;
    public function delete(Thread $thread);
}
