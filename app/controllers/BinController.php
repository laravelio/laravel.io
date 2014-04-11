<?php

use Lio\Bin\Commands;
use Lio\Bin\PasteRepository;
use Illuminate\Http\Request;
use Lio\CommandBus\CommandBus;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector;

class BinController extends BaseController
{
    protected $layout = 'layouts.bin';

    private $bus;
    private $repository;
    /**
     * @var Illuminate\Routing\Redirector
     */
    private $redirector;
    /**
     * @var Illuminate\Http\Request
     */
    private $request;
    /**
     * @var Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(CommandBus $bus, PasteRepository $repository, Redirector $redirector, Request $request, AuthManager $auth)
    {
        $this->bus = $bus;
        $this->repository = $repository;
        $this->redirector = $redirector;
        $this->request = $request;
        $this->auth = $auth;
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
            return $this->redirector->back();
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
        $command = new Commands\CreatePasteCommand($this->request->get('code'), $this->auth->user());
        $paste = $this->bus->execute($command);
        return $this->redirector->action('BinController@getShow', [$paste->hash]);
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
        $command = new Commands\CreateForkCommand($this->request->get('code'), $this->auth->user(), $parent);
        $fork = $this->bus->execute($command);
        return $this->redirector->action('BinController@getShow', [$fork->hash]);
    }

    public function getRaw($hash)
    {
        $paste = $this->repository->getByHash($hash);
        return $this->view('bin.raw', compact('paste'));
    }
}
