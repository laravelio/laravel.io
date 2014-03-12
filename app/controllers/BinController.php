<?php

use Lio\Bin\PasteRepository;
use Lio\Bin\Commands;
use Lio\CommandBus\CommandBus;

class BinController extends BaseController
{
    protected $layout = 'layouts.bin';

    private $bus;
    private $repository;

    public function __construct(CommandBus $bus, PasteRepository $repository)
    {
        $this->bus = $bus;
        $this->repository = $repository;
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
            return $this->redirectBack();
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
        $command = new Commands\CreatePasteCommand(Input::get('code'), Auth::user());
        $paste = $this->bus->execute($command);
        return $this->redirectAction('BinController@getShow', $paste->hash);
    }

    public function getFork($hash)
    {
        $paste = $this->repository->getByHash($hash);
        $this->title = 'Fork Paste';
        $this->view('bin.fork', compact('paste'));
    }

    public function postFork($hash)
    {
        $parent = $this->repository->getByHash($hash);
        $command = new Commands\CreateForkCommand(Input::get('code'), Auth::user(), $parent);
        $fork = $this->bus->execute($command);
        return $this->redirectAction('BinController@getShow', $fork->hash);
    }

    public function getRaw($hash)
    {
        $paste = $this->repository->getByHash($hash);
        return View::make('bin.raw', compact('paste'));
    }
}
