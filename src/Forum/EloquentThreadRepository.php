<?php namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Lio\Accounts\Member;
use Lio\Core\Exceptions\EntityNotFoundException;
use Lio\Forum\Threads\Thread;
use Lio\Tags\TagRepository;

class EloquentThreadRepository extends \Lio\Core\EloquentRepository implements ThreadRepository
{
    /**
     * @var \Lio\Tags\TagRepository
     */
    private $tags;

    public function __construct(Thread $model, TagRepository $tags)
    {
        $this->model = $model;
        $this->tags = $tags;
    }

    public function getByTagsPaginated($tagString, $perPage = 20)
    {
        $tags = $this->tags->getAllTagsBySlug($tagString);

        $query = $this->model->with(['mostRecentReply', 'mostRecentReply.author', 'tags']);

        if ($tags->count() > 0) {
            $query->join('tagged_items', 'forum_threads.id', '=', 'tagged_items.thread_id')
                ->whereIn('tagged_items.tag_id', $tags->lists('id'));
        }

        $query->groupBy('forum_threads.id')
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['forum_threads.*']);
    }

    public function getByTagsAndStatusPaginated($tagString, $status, $perPage = 20)
    {
        $tags = $this->tags->getAllTagsBySlug($tagString);

        $query = $this->model->with(['mostRecentReply', 'tags']);

        if ($tags->count() > 0) {
            $query->join('tagged_items', 'forum_threads.id', '=', 'tagged_items.thread_id')
                ->whereIn('tagged_items.tag_id', $tags->lists('id'));
        }

        if($status) {
            if($status == 'solved') {
                $query->where('solution_reply_id', '>', 0);
            }
            if($status == 'open') {
                $query->whereNull('solution_reply_id');
            }
        }

        $query->groupBy('forum_threads.id')
            ->orderBy('updated_at', 'desc');

        $paginator = $query->paginate($perPage, ['forum_threads.*']);
        $paginator->appends(['tags' => $tagString]);
        return $paginator;

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
        return $this->model->where('slug', '=', $slug)->first();
    }

    public function getRecentByMember(Member $member, $count = 5)
    {
        return $this->model->where('author_id', '=', $member->id)->orderBy('created_at', 'desc')->take($count)->get();
    }

    public function save(Model $model)
    {
        $model->save();
        if ($model->hasUpdatedTags()) {
            $model->tags()->sync($model->getUpdatedTagIds());
        }
    }
}
