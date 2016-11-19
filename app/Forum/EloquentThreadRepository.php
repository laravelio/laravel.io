<?php

namespace App\Forum;

use Illuminate\Support\Arr;
use App\Forum\Exceptions\CouldNotMarkReplyAsSolution;
use App\Forum\Topics\Topic;
use App\Eloquent\GeneratesSlugs;
use App\Replies\Reply;
use App\Users\User;

final class EloquentThreadRepository implements ThreadRepository
{
    use GeneratesSlugs;

    /**
     * @var \App\Forum\EloquentThread
     */
    private $model;

    public function __construct(EloquentThread $model)
    {
        $this->model = $model;
    }

    /**
     * @return \App\Forum\Thread[]|\Illuminate\Contracts\Pagination\Paginator
     */
    public function findAllPaginated()
    {
        return $this->model->orderBy('created_at', 'desc')->paginate(20);
    }

    public function find(int $id): Thread
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug(string $slug): Thread
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function create(User $author, Topic $topic, string $subject, string $body, array $attributes = []): Thread
    {
        $thread = $this->model->newInstance(compact('subject', 'body'));
        $thread->authorRelation()->associate($author);
        $thread->topicRelation()->associate($topic);
        $thread->slug = $this->generateUniqueSlug($subject);
        $thread->ip = Arr::get($attributes, 'ip', '');
        $thread->save();

        $thread = $this->updateTags($thread, $attributes);
        $thread->save();

        return $thread;
    }

    public function update(Thread $thread, array $attributes = []): Thread
    {
        $thread->update(Arr::only($attributes, ['subject', 'body']));

        $thread->slug = $this->generateUniqueSlug($thread->subject(), $thread->id());
        $thread = $this->updateTopic($thread, $attributes);
        $thread = $this->updateTags($thread, $attributes);
        $thread->save();

        return $thread;
    }

    private function updateTopic(EloquentThread $thread, $attributes): EloquentThread
    {
        if ($topic = Arr::get($attributes, 'topic')) {
            $thread->topicRelation()->associate($topic);
        }

        return $thread;
    }

    private function updateTags(EloquentThread $thread, array $attributes): EloquentThread
    {
        if ($tags = Arr::get($attributes, 'tags')) {
            $thread->tagsRelation()->sync($attributes['tags']);
        }

        return $thread;
    }

    public function delete(Thread $thread)
    {
        $thread->delete();
    }

    public function markSolution(Reply $reply): Thread
    {
        $thread = $reply->replyAble();

        if (! $thread instanceof EloquentThread) {
            throw CouldNotMarkReplyAsSolution::replyAbleIsNotAThread($reply);
        }

        $thread->solutionReplyRelation()->associate($reply);
        $thread->save();

        return $thread;
    }

    public function unmarkSolution(Thread $thread): Thread
    {
        $thread->solutionReplyRelation()->dissociate();
        $thread->save();

        return $thread;
    }
}
