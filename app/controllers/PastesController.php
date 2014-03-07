<?php

use Lio\Core\CommandBus;
use Lio\Bin\PasteRepository;
use Lio\Bin\PasteCreatorResponder;
use Lio\Bin\PasteCreator;
use Lio\Bin\PasteForkCreator;
use Lio\Bin\Commands\CreatePasteCommand;

class PastesController extends BaseController implements PasteCreatorResponder
{
    protected $layout = 'layouts.bin';
    private $bus;
    private $repository;
    private $creator;
    private $fork;

    public function __construct(CommandBus $bus, PasteRepository $repository, PasteCreator $creator, PasteForkCreator $fork)
    {
        $this->bus = $bus;
        $this->repository = $repository;
        $this->creator = $creator;
        $this->fork = $fork;
    }

    public function getIndex()
    {
        $pastes = $this->repository->getRecentPaginated();
        $this->title = 'Create Paste';
        $this->view('bin.index', compact('pastes'));
    }

    public function getShow($hash)
    {
        $paste = $this->repository->getByHash($hash);
        if ( ! $paste) {
            return $this->redirectAction('PastesController@getCreate');
        }
        $this->title = 'Paste Viewer';
        $this->view('bin.show', compact('paste'));
    }

    public function getCreate()
    {
        $this->title = 'Create Paste';
        $this->view('bin.create');
    }

    public function postCreate()
    {
        $command = new CreatePasteCommand(Input::get('code'), Auth::user());
        $paste = $this->bus->execute($command);
        return $this->redirectAction('PastesController@getShow', $paste->hash);
    }

    public function getFork($hash)
    {
        $paste = $this->repository->getByHash($hash);
        $this->title = "Fork Paste";
        $this->view('bin.fork', compact('paste'));
    }

    public function postFork($hash)
    {
        $paste = $this->repository->getByHash($hash);
        $this->fork->setListener($this);
        $this->fork->setParentPaste($paste);
        return $this->creator->create($this->fork, Input::get('code'), Auth::user());
    }

    public function getRaw($hash)
    {
        $paste = $this->pastes->getByHash($hash);
        return View::make('bin.raw', compact('paste'));
    }

    // ------------------ //
    public function pasteCreated($paste)
    {
        return $this->redirectAction('PastesController@getShow', $paste->hash);
    }

    public function pasteValidationError($errors)
    {
        return $this->redirectBack()->withErrors($errors);
    }
}
