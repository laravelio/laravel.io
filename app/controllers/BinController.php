<?php

use Lio\Bin\PasteRepository;
use Lio\Bin\PasteCreatorListener;
use Lio\Bin\PasteCreator;

class BinController extends BaseController implements PasteCreatorListener
{
    protected $layout = 'layouts.bin';
    protected $pastes;
    protected $creator;

    public function __construct(PasteRepository $pastes, PasteCreator $creator)
    {
        $this->pastes = $pastes;
        $this->creator = $creator;
    }

    public function getIndex()
    {
        $pastes = $this->pastes->getRecentPaginated();
        $this->view('bin.index', compact('pastes'));
    }

    public function getShow($hash)
    {
        $paste = $this->pastes->getByHash($hash);
        if ( ! $paste) {
            return $this->redirectAction('BinController@getCreate');
        }
        $this->view('bin.show', compact('paste'));
    }

    public function getCreate()
    {
        $this->view('bin.create');
    }

    public function postCreate()
    {
        return $this->creator->create($this, Input::get('code'));
    }

    public function getFork($hash)
    {
        $paste = $this->pastes->getByHash($hash);
        $this->view('bin.fork', compact('paste'));
    }

    public function getRaw($hash)
    {
        $paste = $this->pastes->getByHash($hash);
        $this->view('bin.raw', compact('paste'));
    }

    // ------------------ //
    public function pasteCreated($paste)
    {
        return $this->redirectAction('BinController@getShow', $paste->hash);
    }

    public function pasteValidationError($errors)
    {
        return $this->redirectBack()->withErrors($errors);
    }
}