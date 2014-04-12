<?php namespace Lio\Accounts\Handlers;

use Lio\Accounts\UserRepository;
use Lio\Accounts\Users;
use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;

class CreateUserHandler implements Handler
{
    private $dispatcher;
    /**
     * @var \Lio\Accounts\Users
     */
    private $users;
    /**
     * @var \Lio\Accounts\UserRepository
     */
    private $repository;

    public function __construct(Users $users, UserRepository $repository, Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->users = $users;
        $this->repository = $repository;
    }

    public function handle($command)
    {
        $user = $this->users->addUser($command->email, $command->name, $command->githubUrl, $command->githubId, $command->imageUrl);
        $this->repository->save($user);
        $this->dispatcher->dispatch($this->users->releaseEvents());
        return $user;
    }
}
