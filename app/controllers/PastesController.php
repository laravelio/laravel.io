<?php

use Lio\Bin\PasteRepository;

class PastesController extends BaseController
{
    private $pastes;

    public function __construct(PasteRepository $pastes)
    {
        $this->pastes = $pastes;
    }

    public function getIndex()
    {
        $pastes = $this->pastes->getRecentPaginated();

        $this->view('pastes.index', compact('pastes'));
    }

    public function getShow($paste)
    {
        $this->view('pastes.show', compact('paste'));
    }

    public function getCreate()
    {
        $this->view('pastes.create');
    }
}