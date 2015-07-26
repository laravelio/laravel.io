<?php
namespace Lio\Forum\Threads;

use Illuminate\Support\Collection;
use Lio\Core\Exceptions\EntityNotFoundException;

class ThreadRepository extends \Lio\Core\EloquentRepository
{
    public function __construct(Thread $model)
    {
        $this->model = $model;
    }

    public function getByTagsPaginated(Collection $tags, $perPage = 20)
    {
        $query = $this->model->with(['mostRecentReply', 'mostRecentReply.author', 'tags']);

        if ($tags->count() > 0) {
            $query->join('tagged_items', 'forum_threads.id', '=', 'tagged_items.thread_id')
                ->whereIn('tagged_items.tag_id', $tags->lists('id'));
        }

        $query->groupBy('forum_threads.id')
            ->orderBy('pinned', 'desc')
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['forum_threads.*']);
    }

    public function getByTagsAndStatusPaginated(Collection $tags, $status, $perPage = 20)
    {
        $query = $this->model->with(['author', 'mostRecentReply', 'acceptedSolution']);

        if ($tags->count() > 0) {
            $query->join('tagged_items', 'forum_threads.id', '=', 'tagged_items.thread_id')
                ->whereIn('tagged_items.tag_id', $tags->lists('id'));
            $query->groupBy('forum_threads.id');
        }

        if ($status) {
            if ($status == 'solved') {
                $query->where('solution_reply_id', '>', 0);
            }
            if ($status == 'open') {
                $query->whereNull('solution_reply_id');
            }
        }

        $query->orderBy('pinned', 'desc');
        $query->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['forum_threads.*']);
    }

    public function getThreadRepliesPaginated(Thread $thread, $perPage = 20)
    {
        return $thread->replies()->paginate($perPage);
    }

    public function requireBySlug($slug)
    {
        $model = $this->getBySlug($slug);

        if ( ! $model) {
            throw new EntityNotFoundException;
        }

        return $model;
    }

    public function getBySlug($slug)
    {
        return $this->model->with('author')->where('slug', '=', $slug)->first();
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function deleteByAuthorId($userId)
    {
        return $this->model->where('author_id', $userId)->delete();
    }
}
