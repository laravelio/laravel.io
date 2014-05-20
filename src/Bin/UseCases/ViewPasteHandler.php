<?php namespace Lio\Bin\UseCases; 

use Lio\Bin\Repositories\PasteRepository;
use Lio\CommandBus\Handler;

class ViewPasteHandler implements Handler
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
        return new ViewPasteResponse($this->pasteRepository->getByHash($command->hash));
    }
}
