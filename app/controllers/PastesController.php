<?php

use Lio\Bin\PasteRepository;
use Lio\Bin\PasteCreatorListener;
use Lio\Bin\PasteCreator;
use Lio\Bin\PasteForkCreator;
use Lio\Bin\PasteForm;

class PastesController extends BaseController implements PasteCreatorListener
{
    protected $layout = 'layouts.bin';
    protected $pastes;
    protected $creator;
    protected $fork;

    public function __construct(PasteRepository $pastes, PasteCreator $creator, PasteForkCreator $fork)
    {
        $this->pastes = $pastes;
        $this->creator = $creator;
        $this->fork = $fork;
    }

    public function getIndex()
    {
        $pastes = $this->pastes->getRecentPaginated();
        $this->title = 'Create Paste';
        $this->view('bin.index', compact('pastes'));
    }

    public function getShow($hash)
    {
        $paste = $this->pastes->getByHash($hash);

        if (! $paste) {
            return $this->redirectAction('PastesController@getCreate');
        }

        $this->title = 'Paste Viewer';
        $this->view('bin.show', compact('paste'));
    }

    public function getCreate()
    {
        $this->view('bin.create');
    }

    public function postCreate()
    {
        return $this->creator->create($this, Input::get('paste_data'), Auth::user(), new PasteForm);
    }

    public function getFork($hash)
    {
        $paste = $this->pastes->getByHash($hash);
        $this->title = 'Fork Paste';
        $this->view('bin.fork', compact('paste'));
    }

    public function postFork($hash)
    {
        $paste = $this->pastes->getByHash($hash);
        $this->fork->setListener($this);
        $this->fork->setParentPaste($paste);
        return $this->creator->create($this->fork, Input::get('paste_data'), Auth::user(), new PasteForm);
    }

    public function getRaw($hash)
    {
        $paste = $this->pastes->getByHash($hash);
        return View::make('bin.raw', compact('paste'));
    }

    public function pasteCreated($paste)
    {
        return $this->redirectAction('PastesController@getShow', $paste->hash);
    }

    public function pasteValidationError($errors)
    {
        return $this->redirectBack()->withErrors($errors);
    }
}
