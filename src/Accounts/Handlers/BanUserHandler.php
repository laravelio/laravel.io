<?php namespace Lio\Accounts\Handlers;

use Lio\Accounts\EloquentMemberRepository;
use Lio\Accounts\Users;
use Lio\Core\Handler;
use Mitch\EventDispatcher\Dispatcher;

class BanUserHandler implements Handler
{
    /**
     * @var \Mitch\EventDispatcher\Dispatcher
     */
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
        $this->users = $users;
        $this->dispatcher = $dispatcher;
        $this->repository = $repository;
    }

    public function handle($command)
    {
        $user = $this->users->banUser($command->problem, $command->admin);
        $this->repository->save($user);
        $this->dispatcher->dispatch($this->users->releaseEvents());
        return $user;
    }
}
