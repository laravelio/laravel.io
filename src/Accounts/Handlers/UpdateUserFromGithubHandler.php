<?php namespace Lio\Accounts\Handlers; 

use Lio\Accounts\EloquentMemberRepository;
use Lio\Accounts\Users;
use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;

class UpdateUserFromGithubHandler implements Handler
{
    /**
     * @var \Lio\Accounts\Users
     */
    private $users;
    /**
     * @var \Lio\Accounts\EloquentMemberRepository
     */
    private $repository;
    /**
     * @var \Lio\Events\Dispatcher
     */
    private $dispatcher;

    public function __construct(Users $users, EloquentMemberRepository $repository, Dispatcher $dispatcher)
    {
        $this->users = $users;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $user = $this->users->updateUserFromGithub($command->user, $command->githubUser);
        $this->repository->save($user);
        $this->dispatcher->dispatch($this->users->releaseEvents());
        return $user;
    }
}
