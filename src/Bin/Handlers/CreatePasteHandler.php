<?php namespace Lio\Bin\Handlers;

use Lio\Core\Handler;
use Lio\Bin\PasteRepository;
use Hashids\Hashids;

class CreatePasteHandler implements Handler
{
    private $repository;
    private $hashids;

    public function __construct(PasteRepository $repository, Hashids $hashids)
    {
        $this->repository = $repository;
        $this->hashids = $hashids;
    }

    public function handle($command)
    {
        $paste = $this->createPaste($command->code, $command->user);
        $this->save($paste);
        return $paste;
    }

    private function createPaste($code, $user)
    {
        return $this->repository->getNew(['code' => $code, 'author' => $user]);
    }

    private function save($paste)
    {
        $this->repository->save($paste);
        $this->attachHash($paste);
    }

    private function attachHash($paste)
    {
        $paste->hash = $this->hashids->encrypt($paste->id);
        $this->repository->save($paste);
        return $paste;
    }
}