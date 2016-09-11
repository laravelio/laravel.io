<?php

namespace App\Testing;

trait TestsRepositories
{
    protected $repo;

    /**
     * @before
     */
    public function setUpRepository()
    {
        $this->repo = $this->app->make($this->repoName);
    }

    /**
     * @after
     */
    public function unsetRepository()
    {
        unset($this->repo);
    }
}
