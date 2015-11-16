<?php
namespace Lio\ModelFactories;

use Illuminate\Database\Eloquent\Factory;
use Lio\Forum\EloquentThread;
use Lio\Forum\Thread;
use Lio\Replies\EloquentReply;
use Lio\Replies\Reply;
use Lio\Users\EloquentUser;
use Lio\Users\User;

final class EloquentModelFactory implements ModelFactory
{
    /**
     * @var array
     */
    private $models = [
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

    /**
     * @param string $model
     * @param array $attributes
     * @return object
     */
    public function make($model, array $attributes = [])
    {
        return $this->factory->of($this->resolveModel($model))->make($attributes);
    }

    /**
     * @param string $model
     * @param array $attributes
     * @param int $times
     * @return object
     */
    public function create($model, array $attributes = [], $times = 1)
    {
        return $this->factory->of($this->resolveModel($model))->times($times)->create($attributes);
    }

    /**
     * @param string $model
     * @throws \Lio\ModelFactories\InvalidModelException
     */
    private function resolveModel($model)
    {
        if (! isset($this->models[$model])) {
            throw InvalidModelException::notRegistered($model);
        }

        return $this->models[$model];
    }
}
