<?php

namespace App\ModelFactories;

use Illuminate\Database\Eloquent\Factory;
use App\Forum\EloquentThread;
use App\Forum\Thread;
use App\Forum\Topics\EloquentTopic;
use App\Forum\Topics\Topic;
use App\Replies\EloquentReply;
use App\Replies\Reply;
use App\Tags\EloquentTag;
use App\Tags\Tag;
use App\Users\EloquentUser;
use App\Users\User;

final class EloquentModelFactory implements ModelFactory
{
    /**
     * @var array
     */
    private $models = [
        Reply::class => EloquentReply::class,
        Tag::class => EloquentTag::class,
        Topic::class => EloquentTopic::class,
        Thread::class => EloquentThread::class,
        User::class => EloquentUser::class,
    ];

    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function make(string $model, array $attributes = [])
    {
        return $this->factory->of($this->resolveModel($model))->make($attributes);
    }

    public function create(string $model, array $attributes = [],int  $times = 1)
    {
        return $this->factory->of($this->resolveModel($model))->times($times)->create($attributes);
    }

    private function resolveModel(string $model)
    {
        if (! isset($this->models[$model])) {
            throw InvalidModelException::notRegistered($model);
        }

        return $this->models[$model];
    }
}
