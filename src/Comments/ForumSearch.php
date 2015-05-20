<?php namespace Lio\Comments;

use DB;

class ForumSearch
{
    protected $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    // this stuff is just a placeholder until we implement
    // a real search system
    public function searchPaginated($query, $perPage)
    {
        return $this->model->with(['parent', 'parent.slug', 'parent.mostRecentChild', 'parent.tags', 'slug', 'mostRecentChild', 'tags'])
            ->where('type', '=', Comment::TYPE_FORUM)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('body', 'like', '%' . $query . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->groupBy(DB::raw('least(id, parent_id)'))
            ->remember(2)
            ->paginate($perPage);
    }
}