<?php namespace Lio\Forum\Threads;

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
        $query = $this->model->with(['mostRecentReply', 'tags'])
            ->join('comment_tag', 'forum_threads.id', '=', 'comment_tag.comment_id');

        if ($tags->count() > 0) {
            $query->whereIn('comment_tag.tag_id', $tags->lists('id'));
        }

        $query->groupBy('forum_threads.id')
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['forum_threads.*']);
    }

    public function getThreadRepliesPaginated(Thread $thread, $perPage = 20)
    {
        return $thread->replies()->paginate(20);
    }

    public function requireBySlug($slug)
    {
        $model = $this->model->where('slug', '=', $slug)->first();

        if ( ! $model) {
            throw new EntityNotFoundException;
        }

        return $model;
    }
}