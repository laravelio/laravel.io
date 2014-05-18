<?php namespace Lio\Accounts\Handlers;

use Lio\Accounts\EloquentMemberRepository;
use Lio\Accounts\Users;
use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;

class CreateUserFromGithubHandler implements Handler
{
    private $dispatcher;
    /**
     * @var \Lio\Accounts\Users
     */
    private $users;
    /**
     * @var \Lio\Accounts\EloquentMemberRepository
     */
    private $repository;

    public function __construct(Users $users, EloquentMemberRepository $repository, Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->users = $users;
        $this->repository = $repository;
    }

    public function handle($command)
    {
        $user = $this->users->addUserFromGithub($command->githubUser);
        $this->repository->save($user);
        $this->dispatcher->dispatch($this->users->releaseEvents());
        return $user;
    }
}
