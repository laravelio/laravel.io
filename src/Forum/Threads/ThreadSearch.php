<?php namespace Lio\Forum\Threads;

use DB;

class ThreadSearch
{
    protected $model;

    public function __construct(Thread $model)
    {
        $this->model = $model;
    }

    public function getPaginatedResults($query, $perPage)
    {
        $results = $this->model->with(['mostRecentReply', 'tags'])
            ->where(function($q) use ($query) {
                $q->where('subject', 'like', '%' . $query . '%')
                  ->orWhere('body', 'like', '%' . $query . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, ['forum_threads.*']);
        $results->appends(array('query' => $query));
        return $results;
    }
}
