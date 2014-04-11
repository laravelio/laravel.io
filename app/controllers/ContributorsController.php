<?php

use Lio\Contributors\ContributorRepository;

class ContributorsController extends BaseController
{
    private $contributors;

    public function __construct(ContributorRepository $contributors)
    {
        $this->contributors = $contributors;
    }

    public function getIndex()
    {
        $contributors = $this->contributors->getAllByContributionsPaginated();
        $this->view('contributors.index', compact('contributors'));
    }
}
