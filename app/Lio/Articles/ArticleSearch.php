<?php namespace Lio\Articles;

use Lio\Comments\Comment;
use DB;

class ArticleSearch
{
    protected $model;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    // this stuff is just a placeholder until we implement
    // a real search system
    public function searchPaginated($query, $perPage)
    {
        return $this->model->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->remember(2)
            ->paginate($perPage);
    }
}