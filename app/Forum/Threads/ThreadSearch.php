<?php

namespace Lio\Forum\Threads;

class ThreadSearch
{
    protected $model;

    public function __construct(Thread $model)
    {
        $this->model = $model;
    }

    // this stuff is just a placeholder until we implement
    // a real search system
    public function searchPaginated($query, $perPage)
    {
        return $this->model->with(['mostRecentReply', 'tags'])
            ->where(function ($q) use ($query) {
                $q->where('subject', 'like', '%'.$query.'%')
                  ->orWhere('body', 'like', '%'.$query.'%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, ['forum_threads.*']);
    }
}
