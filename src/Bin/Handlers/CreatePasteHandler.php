<?php namespace Lio\Bin\Handlers;

use Lio\Core\Handler;
use Lio\Bin\PasteRepository;
use Lio\Bin\Bin;
use Hashids\Hashids;

class CreatePasteHandler implements Handler
{
    private $bin;
    private $repository;
    private $hashids;

    public function __construct(Bin $bin, PasteRepository $repository, Hashids $hashids)
    {
        $this->bin = $bin;
        $this->repository = $repository;
        $this->hashids = $hashids;
    }

    public function handle($command)
    {
        $paste = $this->bin->createPaste($command->code, $command->user);
        $this->save($paste);
        return $paste;
    }

    private function save($paste)
    {
        $this->repository->save($paste);
        $this->attachHash($paste);

        $events = $this->bin->releaseEvents();
    }

    private function attachHash($paste)
    {
        $paste->hash = $this->hashids->encrypt($paste->id);
        $this->repository->save($paste);
    }
}