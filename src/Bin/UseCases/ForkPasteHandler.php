<?php namespace Lio\Bin\UseCases; 

use Lio\Bin\Repositories\PasteRepository;
use Lio\CommandBus\Handler;

class ForkPasteHandler implements Handler
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
        $fork = $paste->fork($command->author, $command->code);
        $this->pasteRepository->save($fork);
        return new ForkPasteResponse($fork);
    }
}
