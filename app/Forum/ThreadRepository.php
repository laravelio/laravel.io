<?php

namespace App\Forum;

use App\Forum\Topics\Topic;
use App\Replies\Reply;
use App\Users\User;

interface ThreadRepository
{
    /**
     * @return \App\Forum\Thread[]|\Illuminate\Contracts\Pagination\Paginator
     */
    public function findAllPaginated();

    public function find(int $id): Thread;
    public function findBySlug(string $slug): Thread;
    public function create(User $author, Topic $topic, string $subject, string $body, array $attributes = []): Thread;
    public function update(Thread $thread, array $attributes = []): Thread;
    public function delete(Thread $thread);
    public function markSolution(Reply $reply): Thread;
    public function unmarkSolution(Thread $thread): Thread;
}
