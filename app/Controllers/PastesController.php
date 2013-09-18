<?php namespace Controllers;

use Lio\Bin\PasteRepository;
use Lio\Bin\CommentRepository;

class PastesController extends BaseController
{
    private $pastes;
    private $comments;

    public function __construct(PasteRepository $pastes, CommentRepository $comments)
    {
        $this->pastes   = $pastes;
        $this->comments = $comments;
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
}