<?php

namespace Lio\ModelFactories;

use Illuminate\Database\Eloquent\Factory;
use Lio\Forum\EloquentThread;
use Lio\Forum\Thread;
use Lio\Replies\EloquentReply;
use Lio\Replies\Reply;
use Lio\Tags\EloquentTag;
use Lio\Tags\Tag;
use Lio\Users\EloquentUser;
use Lio\Users\User;

final class EloquentModelFactory implements ModelFactory
{
    /**
     * @var array
     */
    private $models = [
        Tag::class => EloquentTag::class,
        Thread::class => EloquentThread::class,
        Reply::class => EloquentReply::class,
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
