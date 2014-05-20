<?php namespace Lio\Bin\UseCases; 

use Lio\Bin\Repositories\PasteRepository;
use Lio\CommandBus\Handler;

class DeletePasteHandler implements Handler
{
    /**
     * @var \Lio\Bin\Repositories\PasteRepository
     */
    private $pasteRepository;

    public function __construct(PasteRepository $pasteRepository)
    {
        $this->pasteRepository = $pasteRepository;
    }

    public function handle($command)
    {
        $paste = $this->pasteRepository->getByHash($command->hash);
        if ( ! $paste->isOwnerBy($command->author)) {
            throw new \RuntimeException('Paste is not owned by this person.... change this ');
        }
        $this->pasteRepository->delete($paste);
        return new DeletePasteResponse($paste);
    }
}
