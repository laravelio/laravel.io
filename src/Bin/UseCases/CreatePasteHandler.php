<?php namespace Lio\Bin\UseCases; 

use Lio\Bin\Entities\Paste;
use Lio\Bin\Repositories\PasteRepository;
use Lio\CommandBus\Handler;

class CreatePasteHandler implements Handler
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
        $paste = Paste::createPaste($command->author, $command->code);
        $this->pasteRepository->save($paste);
        return new CreatePasteResponse($paste);
    }
}
