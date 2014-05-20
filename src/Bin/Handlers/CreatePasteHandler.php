<?php namespace Lio\Bin\Handlers;

use Lio\CommandBus\Handler;
use Lio\Bin\Repositories\EloquentPasteRepository;
use Lio\Bin\Bin;
use Hashids\Hashids;
use Mitch\EventDispatcher\Dispatcher;

class CreatePasteHandler implements Handler
{
    private $bin;
    private $repository;
    private $hashids;
    private $dispatcher;

    public function __construct(Bin $bin, EloquentPasteRepository $repository, Hashids $hashids, Dispatcher $dispatcher)
    {
        $this->bin = $bin;
        $this->repository = $repository;
        $this->hashids = $hashids;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $paste = $this->bin->addPaste($command->code, $command->author);
        $this->repository->save($paste);
        $this->attachHash($paste);
        $this->dispatcher->dispatch($this->bin->releaseEvents());
        return $paste;
    }

    private function attachHash($paste)
    {
        $paste->hash = $this->hashids->encrypt($paste->id);
        $this->repository->save($paste);
    }
}
