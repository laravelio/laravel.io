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

    /**
     * @param \Lio\Forum\EloquentThread $model
     */
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

    /**
     * @param \Lio\Users\User $author
     * @param string $subject
     * @param string $body
     * @param array $attributes
     * @return \Lio\Forum\Thread
     */
    public function create(User $author, $subject, $body, array $attributes = [])
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

    /**
     * @param \Lio\Forum\Thread $thread
     * @param array $attributes
     * @return \Lio\Forum\Thread
     */
    public function update(Thread $thread, array $attributes = [])
    {
        $thread->update($attributes);

        return $thread;
    }

    /**
     * @param \Lio\Forum\Thread $thread
     */
    public function delete(Thread $thread)
    {
        $thread->delete();
    }
}
