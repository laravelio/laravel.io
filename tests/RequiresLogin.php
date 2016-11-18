<?php

namespace Tests;

trait RequiresLogin
{
    /**
     * @var string
     */
    protected $uri = '/';

    /** @test */
    function requires_login()
    {
        $this->visit($this->uri)
            ->seePageIs('/login');
    }
}
