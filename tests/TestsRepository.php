<?php

namespace Tests;

trait TestsRepository
{
    /**
     * @before
     */
    public function setUpRepository()
    {
        $this->repo = app($this->repo);
    }

    /**
     * @after
     */
    public function unsetRepository()
    {
        unset($this->repo);
    }
}
