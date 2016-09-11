<?php

namespace Tests;

trait RequiresLogin
{
    /** @test */
    function requires_login()
    {
        $this->visit($this->uri)
            ->seePageIs('/login');
    }
}
