<?php  namespace Lio\Bin\Handlers; 

use Hashids\Hashids;
use Lio\Bin\PasteRepository;
use Lio\Bin\Bin;
use Lio\CommandBus\Handler;
use Mitch\EventDispatcher\Dispatcher;

class CreateForkHandler implements Handler
{
    private $bin;
    private $repository;
    private $hashids;
    private $dispatcher;

    public function __construct(Bin $bin, PasteRepository $repository, Hashids $hashids, Dispatcher $dispatcher)
    {
        $this->bin = $bin;
        $this->repository = $repository;
        $this->hashids = $hashids;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $fork = $this->bin->addFork($command->parent, $command->code, $command->author);
        $this->repository->save($fork);
        $this->attachHash($fork);
        $this->dispatcher->dispatch($this->bin->releaseEvents());
        return $fork;
    }

    private function attachHash($fork)
    {
        $fork->hash = $this->hashids->encrypt($fork->id);
        $this->repository->save($fork);
    }
}
