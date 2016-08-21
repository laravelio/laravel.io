<?php

namespace App\Testing;

trait RequiresLogin
{
    /** @test */
    function requires_login()
    {
        $this->visit($this->uri)
            ->seePageIs('/login');
    }
}
