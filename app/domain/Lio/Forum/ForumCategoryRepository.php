<?php namespace Lio\Forum;

use Lio\Core\Exceptions\EntityNotFoundException;
use Lio\Core\EloquentBaseRepository;

class ForumCategoryRepository extends EloquentBaseRepository
{
    public function __construct(ForumCategory $model)
    {
        $this->model = $model;
    }

    public function getForumIndex()
    {
        return $this->model->with(['mostRecentChild', 'mostRecentChild.author'])
                           ->where('show_in_index', '=', 1)
                           ->get();
    }

    public function requireCategoryPageBySlug($slug)
    {
        $model = $this->model->with(['rootThreads', 'rootThreads.slug', 'rootThreads.mostRecentChild', 'rootThreads.mostRecentChild.author'])->where('slug', '=', $slug)->first();

        if ( ! $model) {
            throw new EntityNotFoundException("Could not find forum category: {$slug}");
        }

        return $model;
    }

    public function getThreadForm()
    {
        return new ThreadForm;
    }

    public function getReplyForm()
    {
        return new ReplyForm;
    }
}