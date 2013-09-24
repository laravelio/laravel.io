<?php namespace Controllers;

use Lio\Contributors\ContributorRepository;
use GitHub;

class ContributorsController extends BaseController
{
    private $contributors;

    public function __construct(ContributorRepository $contributors)
    {
        $this->contributors = $contributors;
    }

    public function getIndex()
    {
        $contributors = $this->contributors->getAll();

        $this->view('contributors.index', compact('contributors'));
    }
}