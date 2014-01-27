<?php namespace Lio\Comments;

use Lio\Core\EloquentRepository;
use Lio\Forum\ForumCategory;
use Lio\Articles\Article;
use Illuminate\Support\Collection;

class CommentRepository extends EloquentRepository
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    public function getForumThreadsByTagsPaginated(Collection $tags, $perPage = 20)
    {
        $query = $this->model->with(['slug', 'mostRecentChild', 'tags'])
            ->where('type', '=', COMMENT::TYPE_FORUM)
            ->join('comment_tag', 'comments.id', '=', 'comment_tag.comment_id');

        if ($tags->count() > 0) {
            $query->whereIn('comment_tag.tag_id', $tags->lists('id'));
        }

        $query->groupBy('comments.id')
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['comments.*']);
    }

    public function getThreadCommentsPaginated(Comment $thread, $perPage = 20)
    {
        return $this->model->where(function($q) use ($thread) {

                        $q->orWhere(function($q) use ($thread) {
                            $q->where('parent_id', '=', $thread->id);
                        });
                    })
                    ->where('type', '=', Comment::TYPE_FORUM)
                    ->orderBy('created_at', 'asc')
                    ->with('author')
                    ->paginate($perPage);
    }

    public function getArticleCommentsPaginated(Article $article, $perPage = 20)
    {
    	return $this->model
            ->where('owner_id', '=', $article->id)
            ->where('type', '=', Comment::TYPE_ARTICLE)
    		->orderBy('created_at', 'asc')
    		->paginate($perPage);
    }

    public function getFeaturedForumThreads($count = 3)
    {
        return $this->model->with(['slug', 'tags'])
                   ->where('owner_type', '=', 'Lio\Forum\ForumCategory')
                   ->orderBy('created_at', 'desc')
                   ->take($count)
                   ->get();
    }

    public function requireThreadById($id)
    {
        $model = $this->model->where('id', '=', $id)->where('type', '=', COMMENT::TYPE_FORUM)->first();

        if ( ! $model) {
            throw new EntityNotFoundException;
        }

        return $model;
    }
}