<?php namespace Lio\Comments;

use Lio\Core\EloquentBaseRepository;
use Lio\Forum\ForumCategory;

class CommentRepository extends EloquentBaseRepository
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    public function getForumThreadsByCategoryPaginated(ForumCategory $category, $perPage = 20)
    {

        return $this->model->with(['slug', 'mostRecentChild'])
        					 ->where('owner_type', '=', 'Lio\Forum\ForumCategory')
        					 ->where('owner_id', '=', $category->id)
        					 ->paginate($perPage);
    }

    public function getThreadCommentsPaginated(Comment $thread, $perPage = 20)
    {
    	return $this->model->where(function($q) use ($thread) {
								$q->where(function($q) use ($thread) {
									$q->where('id', '=', $thread->id);
								});

								$q->orWhere(function($q) use ($thread) {
									$q->where('parent_id', '=', $thread->id);
								});
							})
							->orderBy('created_at', 'asc')
							->paginate($perPage);
    }

    public function getFeaturedForumThreads($count = 3)
    {
        return $this->model->with(['slug'])
                           ->where('owner_type', '=', 'Lio\Forum\ForumCategory')
                           ->orderBy('created_at', 'desc')
                           ->take($count)
                           ->get();
    }
}