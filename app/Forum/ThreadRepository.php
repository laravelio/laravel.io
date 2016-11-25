<?php

namespace App\Forum;

use App\Forum\Exceptions\CouldNotMarkReplyAsSolution;
use App\Helpers\GeneratesSlugs;
use App\Replies\Reply;
use Illuminate\Support\Arr;

class ThreadRepository
{
    use GeneratesSlugs;

    /**
     * @var \App\Forum\Thread
     */
    private $model;

    public function __construct(Thread $model)
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

    public function create(NewThread $data): Thread
    {
        $thread = $this->model->newInstance();
        $thread->subject = $data->subject();
        $thread->body = $data->body();
        $thread->authorRelation()->associate($data->author());
        $thread->topicRelation()->associate($data->topic());
        $thread->slug = $this->generateUniqueSlug($data->subject());
        $thread->ip = $data->ip();
        $thread->save();

        $thread = $this->updateTags($thread, $data->tags());
        $thread->save();

        return $thread;
    }

    public function update(Thread $thread, array $attributes = []): Thread
    {
        $thread->update(Arr::only($attributes, ['subject', 'body']));

        $thread->slug = $this->generateUniqueSlug($thread->subject(), $thread->id());
        $thread = $this->updateTopic($thread, $attributes);
        $thread = $this->updateTags($thread, Arr::get($attributes, 'tags', []));
        $thread->save();

        return $thread;
    }

    private function updateTopic(Thread $thread, $attributes): Thread
    {
        if ($topic = Arr::get($attributes, 'topic')) {
            $thread->topicRelation()->associate($topic);
        }

        return $thread;
    }

    private function updateTags(Thread $thread, array $tags): Thread
    {
        if ($tags) {
            $thread->tagsRelation()->sync($tags);
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

        if (! $thread instanceof Thread) {
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
