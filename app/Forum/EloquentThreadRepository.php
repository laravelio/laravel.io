<?php

namespace Lio\Forum;

use Illuminate\Support\Str;
use Lio\Users\User;

final class EloquentThreadRepository implements ThreadRepository
{
    /**
     * @var \Lio\Forum\EloquentThread
     */
    private $model;

    public function __construct(EloquentThread $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Lio\Forum\Thread[]|\Illuminate\Contracts\Pagination\Paginator
     */
    public function findAllPaginated()
    {
        return $this->model->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * @return \Lio\Forum\Thread|null
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @return \Lio\Forum\Thread|null
     */
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function create(User $author, string $subject, string $body, array $attributes = []): Thread
    {
        $thread = $this->model->newInstance(compact('subject', 'body'));
        $thread->author_id = $author->id();

        // Todo: Figure out what to do with these
        $thread->slug = Str::slug($subject);
        $thread->laravel_version = 5;
        $thread->is_question = true;

        $thread->save();

        return $thread;
    }

    public function update(Thread $thread, array $attributes = []): Thread
    {
        $thread->update($attributes);

        return $thread;
    }

    public function delete(Thread $thread)
    {
        $thread->delete();
    }
}
